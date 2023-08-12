<?php
if (isset($_COOKIE['msg'])) {
    setcookie('msg', '', time() - 3600, '/guia_brecho/');
    setcookie('tipo', '', time() - 3600, '/guia_brecho/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/templates/cabecalho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/models/produto.php';

/* if (!isset($_SESSION['admin'])) {
    setcookie('msg', 'Você não tem permissão para acessar este conteúdo', time() + 3600, '/guia_brecho/');
    setcookie('tipo', 'perigo', time() + 3600, '/guia_brecho/');
    header('Location: /guia_brecho/index.php');
    exit();
} */

if ($_SESSION['usuario']['nv_acesso'] == 1) {
    try {
        $produtos = Produto::listarProdutosMinhaLoja($_SESSION['usuario']['id']);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else if ($_SESSION['usuario']['nv_acesso'] == 2) {
    try {
        $produtos = Produto::listar();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>

<section>
    <?php if (isset($_COOKIE['msg'])) : ?>
        <?php if ($_COOKIE['tipo'] === 'sucesso') : ?>
            <div class="alert alert-success text-center m-3" role="alert">
                <?= $_COOKIE['msg'] ?>
            </div>
        <?php elseif ($_COOKIE['tipo'] === 'perigo') : ?>
            <div class="alert alert-danger text-center m-3" role="alert">
                <?= $_COOKIE['msg'] ?>
            </div>
        <?php else : ?>
            <div class="alert alert-info text-center m-3" role="alert">
                <?= $_COOKIE['msg'] ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<section class="d-flex justify-content-center m-5">
    <table class="table table-hover col col-lg-12">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Categoria</th>
                <th scope="col">Preço</th>
                <th scope="col">Em Estoque?</th>
                <th scope="col" colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p) : ?>
                <tr>
                    <td class="col-2"><?= $p['nome_produto'] ?></td>
                    <td class="col-2"><?= $p['categoria'] ?></td>
                    <td class="col-2"><?= $p['preco'] ?></td>
                    <td class="col-2"><?= $p['estoque'] == 1 ? 'Sim' : 'Não' ?></td>
                    <?php if (!$_SESSION['usuario']['nv_acesso'] == 2) : ?>
                        <td class="col-2"><a href="/guia_brecho/views/admin/editar_produto.php?id=<?= $p['id_produto'] ?>">Editar</a></td>
                    <?php endif; ?>
                    <td class="col-2"><a href="/guia_brecho/controllers/produto_delete_controller.php?id=<?= $f['id_produto'] ?>">Deletar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/guia_brecho/templates/rodape.php';
?>