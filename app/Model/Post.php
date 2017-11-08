<?php
class Post extends AppModel
{
    public $belongsTo = array(
        'PostCategory' => array(
            'className' => 'PostCategory',
            'foreignKey' => 'post_category_id'
        ),
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id'
        )
    );
    //Validate
    public $validate = array(
        'post_category_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Chọn chuyên mục'
            )
        ),
        'title' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tiêu đề bài viết'
            ),
            'between' => array(
                'rule' => array('between', 5, 150),
                'message' => 'Tiêu đề bài viết từ %d đến %d ký tự'
            )
        ),
        'summary' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập tóm tắt bài viết'
            ),
            'between' => array(
                'rule' => array('between', 20, 1000),
                'message' => 'Tóm tắt bài viết từ %d đến %d ký tự'
            )
        ),
        'description' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Nhập nội dung bài viết'
            ),
            'between' => array(
                'rule' => array('between', 50, 500000),
                'message' => 'Nội dung bài viết từ %d đến %d ký tự'
            )
        )

    );
}