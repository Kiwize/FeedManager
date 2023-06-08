<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Ajouter une source</title>
</head>

<body data-bs-theme="dark">
    @include('header')
    <section class=" m-lg-3">
        <div class="container d-flex flex-column align-items-center">
            <div class=" form-sub-container p-4 rounded d-flex flex-column align-items-center">
                @csrf
                <div class="form-group w-100">
                    <label for="name">Nom de la source (Entre 6 et 20 caractères)</label>
                    <input type="text" id="name" name="name" class="form-control" required pattern="[a-zA-Z0-9]+" minlength="6" maxlength="20">
                </div>
                <div class="form-group w-100 mt-3">
                    <label for="link">URL de la source</label>
                    <input type="text" id="link" name="link" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button id="submit_button" onclick="submitForm();" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        function submitForm() {
            $.ajax({
                url: '/api/feeds/create',
                type: "POST",
                data: {
                    name: $('#name').val(),
                    link: $('#link').val()
                },
                error: function(err) {
                    alert(err.responseText);
                }, 
                success: function() {
                    window.location.replace('/manager');
                }
            }); 
        }
    </script>
    <style>
        .form-sub-container {
            background-color: #313539;
        }
    </style>
</body>

</html>