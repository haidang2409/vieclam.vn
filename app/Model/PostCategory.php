<?php
class PostCategory extends AppModel
{
    public $useTable = 'posts_categories';
    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_category_id'
        )
    );

    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Tên chuyên mục không được để trống'
            ),
            'between' => array(
                'rule' => array('between', 5, 50),
                'message' => 'Tên chuyên mục  từ %d đến %d ký tự'
            )
        ),
        'link' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập link chuyên mục bài viết'
            ),
            'pattern' => array(
                'rule'      => '/^[0-9a-z-]+$/',
                'message'   => 'Link không có khoảng trắng',
            ),
        ),
    );

}