<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resulmodal">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="resulmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--FORMULARIO-->

                    <form action="">
                        <fieldset>
                            <legend>Serie Roja</legend>
                            <div class="mb-3 row">
                                <label for="inputPassword1" class="col-sm-2 col-form-label">HEMATIES</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword1">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword2" class="col-sm-2 col-form-label">HEMOGLOBINA</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword2">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">HEMATOCRITO</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword3">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Volumen corpuscular medio VCM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword3">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Campo 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword3">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Campo 3</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword3">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Serie Plaqueta</legend>
                            <div class="mb-3 row">
                                <label for="inputPassword4" class="col-sm-2 col-form-label">Campo 4</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword4">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword5" class="col-sm-2 col-form-label">Campo 5</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword5">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Serie Blanca</legend>
                            <div class="mb-3 row">
                                <label for="inputPassword6" class="col-sm-2 col-form-label">Campo 6</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword6">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword7" class="col-sm-2 col-form-label">Campo 7</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPassword7">
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>