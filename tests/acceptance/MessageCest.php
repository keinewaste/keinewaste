<?php


class MessageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function trySendingMessage(AcceptanceTester $I)
    {
        $with = 7;

        $I->sendPOST(
            '/messages', [
                "receiver" => $with,
                "message"  => "test message"
            ]
        );

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson(["receiver" => ["id" => $with]]);
        $I->seeResponseContainsJson(["sender" => ["id" => $with]]);
    }
}
