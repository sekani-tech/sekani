tinymce.init({
  selector: "#textArea",
  plugins: "tinydrive code image link media preview",
  toolbar: "insertfile | undo redo | link image media | code | preview",
  height: 500,
  // Tiny Drive specific options for more details on what these does check https://www.tiny.cloud/docs/plugins/drive/
  tinydrive_token_provider: "jwt.php",
  // tinydrive_upload_path: '/uploads',
  // tinydrive_max_image_dimension: 1024
});
