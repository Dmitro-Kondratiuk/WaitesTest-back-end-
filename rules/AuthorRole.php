<?php
namespace app\rules;

use yii\rbac\Rule;

class AuthorRole extends  Rule
{
    public $name = 'isAuthor';

    public function execute($user_id, $item, $params)
    {
        if(isset($params['author_id']) && ($params['author_id']== $user_id)){
            return true;
        }else{
            return false;
        }
    }
}