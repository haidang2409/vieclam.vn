<?php
class OrdersController extends AppController
{
    //Employer
    ////////////////////////////////////
    function index()
    {
        $this->is_login_employer();
        $this->layout = 'employer_default';
        $employer_id = $this->Session->read('S_Employer.id');
        $orders = array();
        $this->Order->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'recruitments',
                    'alias' => 'Recruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.recruitment_id = Recruitment.id'
                ),
                array(
                    'table' => 'packets',
                    'alias' => 'Packet',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.packet_id = Packet.id'
                ),
            ),
            'limit' => 10,
            'order' => array('Order.id' => 'DESC'),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.title',
                'Order.created',
                'Order.expiry',
                'Order.id',
                'Order.sumamount',
                'Order.discount',
                'Order.status',
                'Packet.packet_name'
            ),
            'paramType' => 'querystring',
            'conditions' => array(
                'Recruitment.employer_id' => $employer_id
            )
        );
        try
        {
            $orders = $this->paginate('Order');
        }
        catch (Exception $exception)
        {

        }
        $this->set(array(
            'orders' => $orders,
            'title' => 'Lịch sử hóa đơn'
        ));
    }

    //Admin
    ////////////////////////////////////
    function admin_index()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }
        $url = $this->params['url'];
        //Packet
        $paket_id = isset($url['packet'])? $url['packet'] : 0;
        $con_packet_id = '';
        if($paket_id != 0)
        {
            $con_packet_id = 'Packet.id = ' . $paket_id;
        }
        //Name
        $name = isset($url['name'])? $url['name']: '';
        $con_username = '';
        $con_email = '';
        if($name != '')
        {
            $con_email = 'Member.email = "' . $name . '"';
            $con_username = 'Member.username = "' . $name . '"';
        }
        //Sattus
        $status = isset($url['status'])? $url['status']: '';
        $con_status = $status != ''? 'Order.status = ' . $status: '';
        //Set
        $packets = null;
        $this->Order->Packet->recursive = -1;
        $packet = $this->Order->Packet->find('all', array(
            'order' => array('id' => 'DESC')
        ));
        foreach ($packet as $item)
        {
            $packets[$item['Packet']['id']] = $item['Packet']['packet_name'];
        }
        $this->set(array(
            'packets' => $packets,
            'packet_id' => $paket_id,
            'status' => $status
        ));
        //
        $this->Order->recursive = -1;
        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'recruitments',
                    'alias' => 'Recruitment',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.recruitment_id = Recruitment.id'
                ),
                array(
                    'table' => 'employers',
                    'alias' => 'Employer',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Recruitment.employer_id = Employer.id'
                ),
                array(
                    'table' => 'packets',
                    'alias' => 'Packet',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => 'Order.packet_id = Packet.id'
                ),
                array(
                    'table' => 'staffs',
                    'alias' => 'Staff',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => 'Order.staff_id = Staff.id'
                ),
            ),
            'limit' => 10,
            'order' => array('Order.id' => 'DESC'),
            'fields' => array(
                'Recruitment.id',
                'Recruitment.title',
                'Employer.id',
                'Employer.company_name',
                'Order.created',
                'Order.expiry',
                'Order.id',
                'Order.sumamount',
                'Order.discount',
                'Order.status',
                'Staff.fullname',
                'Packet.packet_name'
            ),
            'paramType' => 'querystring',
            'conditions' => array(
                $con_packet_id,
                $con_status
            )
        );
        try
        {
            $orders = $this->paginate('Order');
            if($orders)
            {
                $sum_amount = $this->Order->find('first', array(
                    'fields' => array('SUM(Order.sumamount) AS total')
                ));
                $this->set(array(
                    'packets' => $packets,
                    'orders' => $orders,
                    'title' => 'Danh sách hóa đơn',
                    'total' => $sum_amount[0],
                ));
            }
        }
        catch (NotFoundException $e)
        {

        }
    }
    function admin_add()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }

    }
    function admin_edit()
    {
        if(!$this->Session->check('Admin'))
        {
            $this->redirect('/admin/login');
        }

    }


}