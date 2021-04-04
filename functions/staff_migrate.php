
<html>
<head>
</head>
<body>
  <h2>Migrate Excel sheet into the system</h2>
    
  <div class="outer-container">
      <form action="" method="post"
          name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
          <div>
              <label>Choose Excel
                  File</label> <input type="file" name="file"
                  id="file" accept=".xls,.xlsx">
              <button type="submit" id="submit" name="import"
                  class="btn-submit">Import</button>
      
          </div>
      
      </form>
      
  </div>
  <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?><?php if(!empty($message)) { echo $message; } ?></div>
</body>
</html>
<?php

?>
