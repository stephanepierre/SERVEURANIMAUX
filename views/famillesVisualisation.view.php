<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Famille</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($familles as $famille) : ?>
            <tr>
                <td><?= $famille['famille_id'] ?></td>
                <td><?= $famille['famille_libelle'] ?></td>
                <td><?= $famille['famille_description'] ?></td>
                <td><button class="btn btn-warning">Modifier</button></td>
                <td>
                    <form methode="post" action="<?= URL ?>back/familles/validationSuppression" onSubmit="return confirm('Voulez-vous vraiment supprimer ?')">
                    <input type="hidden" name="famille_id" value="<?= $famille['famille_id'] ?>" />
                        <button class="btn btn-danger" type="submit">Supprimer</button>   
                    </form>
                </td>
             </tr>
                <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean();
$titre = "Les familles";
require "views/commons/template.php";