<?php


class UserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }



    public function getWrongToken(AcceptanceTester $I)
    {
        $I->amBearerAuthenticated('wrong_token');
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(403);
    }

    public function getUnauthorized(AcceptanceTester $I)
    {
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(403);
    }

    public function getMySelf(AcceptanceTester $I)
    {
        $accessToken = 'CAAYBQjWI6owBAI9V7ZBZArN1jufoZCn9YEpi04ImtmpVbHWJ2qZBkEwH7lnRzZBaU6gzFoBCTdmXbF1FqzqDAm5Yz5p3ZBkG25DM3K4aYa7FyXflZBSn5eDQR9BEejouH4AArJqMNUt74cFiEjxSWppQ1snOoZBMEe3ZCx3TXOxpTsHr7oJ0ZCte2GsjtofFD5w9KEC31WZAZCPf29H64LJVbUof';
        $I->amBearerAuthenticated($accessToken);
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(200);
    }
}
