<?php
require_once "autoload.php";

if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $display = new Display();
    $display->head('Articles');
    $display->navTop();
    $display->sideBar();
    $data = new Article();
    $tab = $data->all();
    $like = new Manage();
    $_CATEGORIE = ['Musique', 'Web', 'Lifestyle', 'Culture', 'Humeur'];
    ?>
    <body class="blue-grey lighten-5">
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="sweetAlert/sweetalert.min.js"></script>
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Content</th>
                <th>Categorie</th>
                <th>Publié</th>
                <th>Like</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $count = count($tab);
            for ($i = 0; $i < $count; $i++) {
                $data_like = $like->DisplayLike($tab[$i]['id']);


                echo '<tr>';
                echo '<td>' . $tab[$i]['id'] . '</td>';
                echo '<td>' . $tab[$i]['titre'] . '</td>';
                echo '<td>' . strip_tags(substr($tab[$i]['content'], 0, 100)) . '...</td>';
                echo '<td>' . $_CATEGORIE[$tab[$i]['categorie']] . '</td>';
                echo '<td>' .$tab[$i]['publication']. '</td>';
                echo '<td>' .$data_like['nb_like']. '</td>';
                echo '<td><a href="/Login/Preview/' . $tab[$i]['id'] . '"><i class="material-icons green-text text-darken-4">remove_red_eye</i></a></td>';
                echo '<td><a href="article_modify.php?id=' . $tab[$i]['id'] . '"><i class="material-icons blue-text text-darken-4">edit</i></a></td>';
                echo '<td><a href="#" data-id="' . $tab[$i]['id'] . '" class="delete"><i class="material-icons red-text text-darken-2">delete</i></a></td>';
                echo '</tr>';

            }
            ?>
            <tr>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>
    </body>
    <script>
        $(".button-collapse").sideNav();

        $('.delete').click(function () {
            var id = $(this).data('id');
            var element = ($(this).parent().parent());
            swal({
                    title: "Etes vous sur ?",
                    text: "La suppression sera definitive",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dd5044",
                    confirmButtonText: "Oui, je confirme",
                    cancelButtonText: "Non, surtout pas ",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.post("delete.php",
                            {id: id},
                            function (data) {
                                element.remove();
                            });


                        swal("Supprimé!", "Suppression reussie", "success");
                    } else {
                        swal("Annuler", "Aucune suppression n'a été éffectué", "error");
                    }
                });
        })
    </script>

    <?php

} else {
    header('location:Home');
    die();
}
