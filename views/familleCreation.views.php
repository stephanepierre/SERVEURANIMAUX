<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/familles/creationValidation">
    <div class="form-group">
        <label for="famille_libelle">Libelle</label>
        <input type="text" class="form-control" id="famille_libelle" name="famille_libelle">
    </div>
    <div class="form-group">
        <label for="famille_description">Description</label>
        <textarea class="form-control" id="famille_description" name="famille_description" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php 
$content = ob_get_clean();
$titre = "Page de création d'une famille";
require "views/commons/template.php";