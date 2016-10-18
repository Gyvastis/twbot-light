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
        $categoryArray = self::getCategoryMessagesArray();
        $messages = [];

        foreach($categoryArray as $messageCategoryName => $contentArray){
            foreach($contentArray['messages'] as $messageText) {
                $message = new Message();

                $message->setMessage($messageText);

                $messages[] = $message;
            }

            break;
        }

        return $messages;
    }

    /**
     * @param string $categoryName
     * @return array
     */
    public static function getTags($categoryName)
    {
        $categoryArray = self::getCategoryMessagesArray();
        $tags = [];

        foreach($categoryArray as $messageCategoryName => $contentArray){
            if($messageCategoryName != $categoryName || !isset($contentArray['tags'])){
                continue;
            }

            $tags = $contentArray['tags'];

            break;
        }

        return $tags;
    }
}