<?php
/**
 * 消息控制器
 */
class MessageController extends StudentController {
	public function actionIndex() {
        Message::model()->updateAll(
            array('state' => 0),
            'receiver=:receiver',
            array(
                ':receiver' => $_SESSION['student']['sid'],
            ));

        $this->unReadMsg = array();
        $this->render('index', array(
            'messages' => Message::model()->findAll(array(
                'condition' => 'receiver=:receiver',
                'order' => 'time DESC',
                'params' => array(
                    ':receiver' => $_SESSION['student']['sid'],
                ),
            )),
        ));
	}

    public function actionSend() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = new Message;
            $message->receiver = $_POST['receiver'];
            $message->sender = $_SESSION['student']['sid'];
            $message->message = $_POST['message'];
            $message->time = date('Y-m-d H:i:s');
            $message->state = 1;
            $message->save();
        }
    }
}