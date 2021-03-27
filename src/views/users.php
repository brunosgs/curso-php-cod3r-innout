<main class="content">
    <?php
    renderTitle('Cadastro de usuários', 'Matenha os dados dos usuários atualizados', 'icofont-users');
    include(TEMPLATE_PATH . '/messages.php');
    ?>

    <a class="btn btn-lg btn-primary mb-4" href="save_user.php">Novo usuário</a>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de admissão</th>
            <th>Data de desligamento</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->start_date ?></td>
                    <td><?= $user->end_date ?></td>
                    <td>
                        <a href="save_user.php?update=<?= $user->id ?>" class="btn btn-warning rounded-circle mr-2">
                            <i class="icofont-edit"></i>
                        </a>
                        <a href="?delete=<?= $user->id ?>" class="btn btn-danger rounded-circle">
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>