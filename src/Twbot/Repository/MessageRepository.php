<?php

namespace Twbot\Repository;

use Symfony\Component\Yaml\Yaml;
use Twbot\Entity\Message;

class MessageRepository
{
    /**
     * @return array
     */
    public static function getCategoryMessagesArray()
    {
        return Yaml::parse(file_get_contents(MESSAGES_DATA_FILE));
    }

    /**
     * @param string $categoryName
     * @return Message[]
     */
    public static function getMessages($categoryName)
    {
        $messagesCategoryArray = self::getCategoryMessagesArray();
        $messages = [];

        foreach($messagesCategoryArray as $messageCategoryName => $messageTexts){
            if($messageCategoryName != $categoryName){
                continue;
            }

            foreach($messageTexts as $messageText) {
                $message = new Message();

                $message->setMessage($messageText);

                $messages[] = $message;
            }
        }

        return $messages;
    }
}