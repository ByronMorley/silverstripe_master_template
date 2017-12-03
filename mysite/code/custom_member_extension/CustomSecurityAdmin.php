<?php

class CustomSecurityAdmin extends DataExtension
{
    public function updateEditForm($form)
    {
        $fields = $form->Fields();
        $dataColumns = $form->Fields()->fieldByName("Members")->getConfig()->getComponentByType('GridFieldDataColumns');
        $dataColumns->setDisplayFields(array(
            'Username' => 'Username',
            'Email' => 'Email',
            'LastVisited' => 'Last Visited'
        ));

        return $form;
    }
}