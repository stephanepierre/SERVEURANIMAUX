<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Animal</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($animaux as $animal) : ?>
            <tr>
                <td><?= $animal['animal_id'] ?></td>
                <td><?= $animal['animal_nom'] ?></td>
                <td><?= $animal['animal_description'] ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="animal_id" value="<?= $animaux['animal_id'] ?>" />
                        <button class="btn btn-warning" type="submit">Modifier</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="<?= URL ?>back/animaux/validationSuppression" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                        <input type="hidden" name="famille_id" value="<?= $animal['animal_id'] ?>" />
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean();
$titre = "Les animaux";
require "views/commons/template.php";