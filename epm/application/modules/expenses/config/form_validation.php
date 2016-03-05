<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(  
                
                'expense' => array(
                                    array(
                                            'field' => 'project',
                                            'label' => 'Project',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'amount',
                                            'label' => 'Amount',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'category',
                                            'label' => 'Category',
                                            'rules' => 'required'
                                         )
                                    )        
);