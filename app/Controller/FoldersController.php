<?php
class FoldersController extends AppController
{


    //Employer
    function add_folder_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            if($this->request->is('post'))
            {
                $this->Folder->set('employer_id', $employer_id);
                $this->Folder->set('folder_name', $this->request->data['folder_name']);
                $this->Folder->set('color', $this->request->data['color']);
                if($this->Folder->save())
                {
                    echo json_encode(array('status' => 'success'));
                }
                else
                {
                    echo json_encode(array('status' => 'fail'));
                }

            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }
    function delete_folder_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            $folder_id = $this->request->data['folder_id'];
            $this->Folder->MemberEmployer->recursive = -1;
            $count_resume_saved = $this->Folder->MemberEmployer->find('count', array(
                'conditions' => array(
                    'folder_id' => $folder_id
                )
            ));
            if($count_resume_saved > 0)
            {
                echo json_encode(array('status' =>'exist_resume'));
            }
            else
            {
                if($this->Folder->deleteAll(array('Folder.id' => $folder_id, 'employer_id' => $employer_id)))
                {
                    echo json_encode(array('status' => 'success'));
                }
                else
                {
                    echo json_encode(array('status' => 'fail'));
                }
            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }
    function edit_folder_ajax()
    {
        $this->autoRender = false;
        if($this->Session->check('S_Employer'))
        {
            $employer_id = $this->Session->read('S_Employer.id');
            if($this->request->is('post'))
            {
                $folder_id = $this->request->data['id'];
                $folder_name = $this->request->data['folder_name'];
                $color = $this->request->data['color'];
                $data = array(
                    'folder_name' => "'$folder_name'",
                    'color' => "'$color'"
                );
                if($this->Folder->updateAll($data, array('Folder.id' => $folder_id, 'Folder.employer_id' => $employer_id)))
                {
                    echo json_encode(array('status' => 'success'));
                }
                else
                {
                    echo json_encode(array('status' => 'fail'));
                }

            }
        }
        else
        {
            echo json_encode(array('status' => 'not_login'));
        }
    }
}