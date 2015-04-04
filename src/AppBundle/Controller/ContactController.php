<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Form\ContactType;

/**
 * Contact Controller
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     */
    public function indexAction()
    {
        $form = $this->get('form.factory')->create(new ContactType(), array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST',
        ));


        // Get the request
        $request = $this->get('request');

        // Check the method
        if ('POST' === $request->getMethod())
        {
            // Bind value with form
            $form->bind($request);

            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setFrom($data['email'])
                ->setSubject($data['subject'])
                ->setTo('web.rault@gmail.com')
                ->setBody($data['content']);

            $this->get('mailer')->send($message);

            // Launch the message flash
            $this->get('session')->setFlash('notice', 'Merci de nous avoir contacté !');
        }

        return $this->render('AppBundle:Contact:contact.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }
}