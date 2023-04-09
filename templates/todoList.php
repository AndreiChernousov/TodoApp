<?php

include '../templates/header.php';

use App\Helper;
use App\Models\TodoItemModel;

/**
 * @var array $items - todo items
 * @var array $sort - sort params
 * @var int $pageTotal - total pages
 * @var int $createItem - item created
 * @var array $error - errors
 * @var array $user - user data
 */

$curPage = Helper::getCurPage();
$sortTop = "<span class='sort'>↑</span>";
$sortBottom = "<span class='sort'>↓</span>";
$curSort = $sort['sortOrder'] == 'asc' ? $sortTop : $sortBottom;
?>

<div class="container mt-5">
    <h2>Todo List Table</h2>
    <?php if(isset($createItem) && $createItem):?>
        <div class="alert alert-success" role="alert">New item created</div>
    <?php endif;?>
    <?php if(isset($error)):?>
        <?php foreach($error as $curError):?>
            <div class="alert alert-danger" role="alert"><?=$curError?></div>
        <?php endforeach;?>
    <?php endif;?>

    <table class="table table-striped">
        <thead>
        <tr>
            <?php if(isset($user['isAdmin']) && $user['isAdmin']):?>
                <th class="col-edit"></th>
            <?php endif;?>
            <th class="col-name"><a href="<?=Helper::getSortUrl($_SERVER['REQUEST_URI'], 'name')?>">Name <?= $sort['sortBy']=='name'?$curSort:''?></a></th>
            <th class="col-email"><a href="<?=Helper::getSortUrl($_SERVER['REQUEST_URI'], 'email')?>">Email <?= $sort['sortBy']=='email'?$curSort:''?></a></th>
            <th class="col-text">Text</th>
            <?php if(isset($user['isAdmin']) && $user['isAdmin']):?>
                <th class="col-status"><a href="<?=Helper::getSortUrl($_SERVER['REQUEST_URI'], 'status')?>">Status <?= $sort['sortBy']=='status'?$curSort:''?></a></th>
            <?php else:?>
                <th class="col-status"><a href="<?=Helper::getSortUrl($_SERVER['REQUEST_URI'], 'status')?>">Status <?= $sort['sortBy']=='status'?$curSort:''?></a></th>
            <?php endif;?>
        </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item):?>
                <tr data-id="<?=$item['id']?>">
                    <?php if(isset($user['isAdmin']) && $user['isAdmin']):?>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-secondary edit-btn"><span class="bi bi-pencil"></span></button>
                            </div>
                            <div class="btn-group hidden" role="group" >
                                <button type="button" class="btn btn-sm btn-outline-secondary  text-success save-btn"><span class="bi bi-check"></span></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary text-danger cancel-btn"><span class="bi bi-x"></span></button>
                            </div>
                        </td>
                    <?php endif;?>
                    <td><?= $item['name']?></td>
                    <td><?= $item['email']?></td>
                    <td><span class="editable-area"><?=$item['description']?></span></td>
                    <td>
                        <?php if(isset($user['isAdmin']) && $user['isAdmin']):?>
                            <?php if($item['status'] == TodoItemModel::STATUS_NEW):?>
                                <span class="status"><a href="#" class="changeStatus" title="change status to completed"><?= $item['status']?></a></span>
                            <?php else:?>
                                <span class="status"><?= $item['status']?></span>
                            <?php endif;?>
                        <?php else:?>
                            <span class="status"><?= $item['status']?></span>
                        <?php endif;?>
                        <span class="small edited-status <?=(!$item['edited'])?'hidden':''?>">Edited</span>
                    </td>
                </tr>
            <?php endforeach?>
            <tr class="addForm">
                <?php if(isset($user['isAdmin']) && $user['isAdmin']):?>
                    <td></td>
                <?php endif;?>
                <td><input class="w-100" type="text" name="name" autocomplete="off" form="addTodoForm" value="<?=(isset($error))?Helper::filterString($_REQUEST['name']):''?>"/></td>
                <td><input class="w-100" type="text" name="email" autocomplete="off" form="addTodoForm" value="<?=(isset($error))?Helper::filterString($_REQUEST['email']):''?>"/></td>
                <td><textarea class="w-100" name="description" autocomplete="off" form="addTodoForm"/> <?=(isset($error))?Helper::filterString($_REQUEST['description']):''?></textarea></td>
                <td><button class="btn btn-primary btn-save w-100 sendBtn" type="submit" form="addTodoForm">Сохранить</button></td>
            </tr>
        </tbody>
    </table>
    <form action="" method="POST" id="addTodoForm">
        <input name="action" value="createItem" type="hidden">
    </form>

    Pagination:
    <?php for($page = 1; $page <= $pageTotal; $page++):?>
        <?php if($page == $curPage):?>
            <?=$page?>
        <?php else:?>
            <a href='<?=Helper::getPageUrl($_SERVER['REQUEST_URI'], $page)?>'><?=$page?></a>
        <?php endif?>
    <?php endfor?>
    <div class="mt-5"><a href="auth/" class="btn btn-primary">Авторизация</a></div>
</div>

<?php include '../templates/footer.php'; ?>