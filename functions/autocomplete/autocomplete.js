var suggest = {
    instance: {}, // attached instances
    focus: null, // current text field in focus

    attach: function (opt) {
        // suggest.attach () : attach autosuggest to input field
        // opt : options
        //  - target : ID of target input field, required
        //  - url : Target URL to fetch suggestions, required
        //  - delay : Delay before autocomplete fires up, optional, default 500ms
        //  - min : Minimum characters to fire up autocomplete, default 2

        // Create autocomplete wrapper and box
        var id = Object.keys(suggest.instance).length,
            input = document.getElementById(opt.target);
        input.outerHTML = "<div id='acWrap" + id + "' class='acWrap'>" +
            input.outerHTML + "<div id='acBox" + id + "' class='acBox'></div></div>";

        // Set the HTML references and options
        suggest.instance[opt.target] = {
            input: document.getElementById(opt.target),
            wrap: document.getElementById("acWrap" + id),
            box: document.getElementById("acBox" + id),
            delay: opt.delay ? opt.delay : 500,
            url: opt.url,
            min: opt.min ? opt.min : 2,
            timer: null
        };

        // Attach key listener
        suggest.instance[opt.target].input.addEventListener("keyup", function (evt) {
            // Clear old timer
            if (suggest.instance[opt.target].timer != null) {
                window.clearTimeout(suggest.instance[opt.target].timer);
            }

            // Hide and clear old suggestion box
            suggest.instance[opt.target].box.innerHTML = "";
            suggest.instance[opt.target].box.style.display = "none";

            // Create new timer, only if minimum characters
            if (evt.target.value.length >= suggest.instance[opt.target].min) {
                suggest.instance[opt.target].timer = setTimeout(
                    function () {
                        suggest.fetch(evt.target.id);
                    },
                    suggest.instance[opt.target].delay
                );
            }
        });

        // This is used to hide the suggestion box if the user navigates away
        suggest.instance[opt.target].input.addEventListener("focus", function (evt) {
            if (suggest.focus != null) {
                suggest.close(null, true);
            }
            suggest.focus = opt.target;
        });
    },

    fetch: function (id) {
        // suggest.fetch() : AJAX get suggestions and draw
        // id : ID of target input field, automatically passed in by keyup event

        let req = new XMLHttpRequest();
        req.addEventListener("load", function () {
            let data = JSON.parse(this.response);
            if (data.length > 0) {
                data.forEach(function (el) {
                    suggest.instance[id].box.insertAdjacentHTML("beforeend", "<div onclick=\"suggest.select('" + id + "', this);\">" + el + "</div>");
                });
                suggest.instance[id].box.style.display = "block";
                document.addEventListener("click", suggest.close);
            }
        });
        // here is where i can put session id and branch id for loading
        req.open("GET", suggest.instance[id].url + "?term=" + suggest.instance[id].input.value);
        req.send();
    },

    select: function (id, el) {
        // suggest.select() : user selects a value from autocomplete

        suggest.instance[id].input.value = el.innerHTML;
        suggest.instance[id].box.innerHTML = "";
        suggest.instance[id].box.style.display = "none";
        document.removeEventListener("click", suggest.close);
    },

    close: function (evt, force) {
        // suggest.close() : close the autocomplete box if the user clicks away from the input field
        // evt : click event
        // force : force close

        if (force || event.target.closest(".acWrap") == null) {
            suggest.instance[suggest.focus].box.innerHTML = "";
            suggest.instance[suggest.focus].box.style.display = "none";
            document.removeEventListener("click", suggest.close);
        }
    }
};