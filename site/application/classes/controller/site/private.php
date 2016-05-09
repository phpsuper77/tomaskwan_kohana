<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Private extends Controller_Site_Base
{
    public function before()
    {
        parent::before();
        if (!Auth::instance()->logged_in_user())
        {
            $this->request->redirect('/');
        }
        $this->setupPage();
    }

    public function setupPage()
    {
        if($this->loginUserObj->getRole() != Model_User::ROLE_USER)
        {
            //checking invoices
            if($this->user['superior']==NULL) //only for no-staff
            {
/*
                $this->modelInvoice = new Model_Invoice();
                if($this->modelInvoice->checkPrices($this->loginUserObj->getId())==TRUE && $this->modelInvoice->checkInvoice($this->loginUserObj->getId())==TRUE)
                {
                    $invoice = $this->modelInvoice->addInvoice($this->loginUserObj->getId());
                    //send message
                    if($this->loginUserObj->canNotify('email') == TRUE)
                    {
                        $body = View::factory('site/emails/template');
                        $body->text = View::factory('site/emails/invoice');
                        $body->text->invoice = $invoice;
                        sendMail('You have received new invoice on Gymhit',$this->loginUserObj->getEmail(),$body);
                    }
                    //sending sms if set
                    if($this->loginUserObj->canNotify('sms') == TRUE)
                    {
                        $body = View::factory('site/sms/invoice');
                        $body->invoice = $invoice;
                        sendSMS($this->loginUserObj->getPhone(),$body);
                    }
                }
*/

/*
                //checking unpaid invoice
                $u_invoice = $this->modelInvoice->checkUnpaidInvoice($this->loginUserObj->getId());
                if($u_invoice != FALSE)
                {
                    //blocing page
                    $this->modelPage->activePage($this->loginUserObj->getId(),0);
                    //send message
                    if($this->loginUserObj->canNotify('email') == TRUE)
                    {
                        $body = View::factory('site/emails/template');
                        $body->text = View::factory('site/emails/u_invoice');
                        $body->text->invoice = $u_invoice;
                        sendMail('You have unpaid invoice on Gymhit',$this->loginUserObj->getEmail(),$body);
                    }
                    //sending sms if set
                    if($this->loginUserObj->canNotify('sms') == TRUE)
                    {
                        $body = View::factory('site/sms/u_invoice');
                        $body->invoice = $u_invoice;
                        sendSMS($this->loginUserObj->getPhone(),$body);
                    }
                }
*/
            }
        }

    }
}
