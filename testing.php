<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Formspark with Uploadcare</title>
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
  </head>
  <body>
    <form action="https://submit-form.com/gv71Ixa2">
      <!-- Name -->
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Name" required="" />

      <!-- Photo -->
      <label for="photo">Photo</label>
      <input type="hidden" data-multiple="true" id="photo" name="photo" role="uploadcare-uploader" accept="cert.jpg, cert.jpeg, cert.png" data-public-key="18ac0735c32556ab0298"/>
      <button type="submit">Send</button>
    </form>
  </body>
</html>