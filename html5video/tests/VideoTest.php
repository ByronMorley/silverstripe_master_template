<?php

/**
 * Class VideoTest
 */
class VideoTest extends HTML5VideoTest
{

    /**
     * Method that tests basic page creation
     * for VideoGroup.
     */
    public function testVideoCreate()
    {
        $video = singleton('Video');
        $this->logInAs('JonDoe');

        $this->assertTrue($video->canCreate(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't add Video pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($video->canCreate(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can add Video pages but shouldn't be able to.");
        $this->logOut();
    }

    /**
     *
     */
    public function testVideoEdit()
    {
        $video = $this->objFromFixture('Video', 'Video1');
        $this->logInAs('JonDoe');

        $this->assertTrue($video->canEdit(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't edit Video pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($video->canEdit(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can edit Video pages but shouldn't be able to.");
        $this->logOut();
    }

    /**
     *
     */
    public function testVideoDelete()
    {
        $video = $this->objFromFixture('Video', 'Video1');
        $this->logInAs('JonDoe');

        $this->assertTrue($video->canDelete(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't delete Video pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($video->canDelete(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can delete Video pages but shouldn't be able to.");
        $this->logOut();
    }

}