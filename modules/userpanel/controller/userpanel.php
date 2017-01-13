<?php
/**
 * Created by PhpStorm.
 * User: mmuno
 * Date: 15/07/2016
 * Time: 10:29
 */

namespace GLFramework\Modules\UserPanel;


use GLFramework\Controller\AuthController;
use GLFramework\Filesystem;
use GLFramework\Image\ImageProcessing;
use GLFramework\Upload\Uploads;

class userpanel extends AuthController
{
    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub

        if(isset($_POST['save']))
        {
            $this->user->setData($_POST);
            $upload = $this->getUploads()->allocate("picture");
            if($upload->isSuccess() && !$upload->isEmpty())
            {
                $name = "image_" . $this->user->id . ".png";
                $upload->setName($name);
                $image = new ImageProcessing($upload->tmpName());
                $image->open($upload->contentType());
                $image->resize_image(64, 64, false);
                $image->save($upload->getAbsolutePath());
                $this->user->profile_image = $upload->url();
            }
            $this->user->save();
            $this->addMessage("Se ha actualizado correctamente la informacion de perfil");
        }
        if(isset($_POST['change_password']))
        {
            if($this->user->password == $this->user->encrypt($_POST['password']))
            {
                if(strlen($_POST['password1']) >= 6)
                {
                    if($_POST['password1'] == $_POST['password2'])
                    {
                        $this->user->password = $this->user->encrypt($_POST['password1']);
                        $this->user->save();
                        $this->addMessage("Se ha cambiado la contraseña correctamente");
                    }
                    else
                    {
                        $this->addMessage("La contraseñas no coinciden", "danger");
                    }
                }
                else
                {
                    $this->addMessage("La contraseñas nueva es damasiado corta, minimo 6 caracteres", "danger");
                }
            }
            else
            {
                $this->addMessage("La contraseña actual no es válida", "danger");
            }
        }
    }


}