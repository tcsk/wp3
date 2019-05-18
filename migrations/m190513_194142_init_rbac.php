<?php

use yii\db\Migration;

/**
 * Class m190513_194142_init_rbac
 */
class m190513_194142_init_rbac extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "addUser" permission
        $addUser = $auth->createPermission('addUser');
        $addUser->description = 'Create new user';
        $auth->add($addUser);

        // add "updateUser" permission
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        // add "removeUser" permission
        $removeUser = $auth->createPermission('removeUser');
        $removeUser->description = 'Remove user';
        $auth->add($removeUser);

        // add "addCardPair" permission
        $addCardPair = $auth->createPermission('addCardPair');
        $addCardPair->description = 'Create new card pair';
        $auth->add($addCardPair);

        // add "updateCardPair" permission
        $updateCardPair = $auth->createPermission('updateCardPair');
        $updateCardPair->description = 'Update card pair';
        $auth->add($updateCardPair);

        // add "removeCardPair" permission
        $removeCardPair = $auth->createPermission('removeCardPair');
        $removeCardPair->description = 'Remove card pair';
        $auth->add($removeCardPair);

        // add "teacher" role and give this role the "createPost" permission
        $teacher = $auth->createRole('teacher');
        $auth->add($teacher);
        $auth->addChild($teacher, $addCardPair);
        $auth->addChild($teacher, $updateCardPair);
        $auth->addChild($teacher, $removeCardPair);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $addUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $removeUser);
        $auth->addChild($admin, $teacher);

        $auth->assign($admin, 1);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
