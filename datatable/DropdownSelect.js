//The dictionary array containing the states and cities
var oStatename=[
{"state":"Abia",
  "lga":["Aba North","Aba South","Arochukwu","Bende","Ikwuano","Isiala-Ngwa North",
"Isiala-Ngwa South","Isiukwato","Obi Ngwa","Ohafia","Osisioma","Ugwunagbo","Ukwa East","Ukwa West",
"Umuahia North","Umuahia South","Umu-Neochi"]},
{"state":"Adamawa",
"lga":
["Demsa","Fufore","Ganaye","Gireri","Gombi","Guyuk","Hong","Jada","Lamurde",
"Madagali","Maiha","Mayo-Belwa","Michika","Mubi North","Mubi South","Numan","Shelleng","Song",
"Toungo","Yola North","Yola South"]}
];

//Function to initialize the options (Populate States and Cities with the cities from 1st state)
window.onload = function(){

    var selState = document.getElementById('selState');//Select State Drop Down List

    //Create all States options
    for(var i = 0; i < oStatename.length; i++)
    {
        createOption(selState, oStatename[i]["state"],oStatename[i]["state"]);//Create State DropDown option
    }

    //Itinialize the 2nd dropdown with cities from 1st state (selected by default)
    configureDropDownLists();

}

//This function populates the city drop down according to the selected state
function configureDropDownLists() {

     var selState = document.getElementById('selState');//Select State Drop Down List
     var selCity = document.getElementById('selCity');// Select City Drop Down List

     selCity.options.length = 0;// reset City Drop Down Options
     for (i = 0; i < oStatename[selState.selectedIndex]["lga"].length; i++) //Create options based on selected state
     {
                createOption(selCity, oStatename[selState.selectedIndex]["lga"][i], oStatename[selState.selectedIndex]["lga"][i]);
     }

}
//Create an option and add it to the drop down list "ddl" with text and value
function createOption(ddl, text, value) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    ddl.options.add(opt);
}