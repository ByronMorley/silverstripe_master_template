<?php

/**
 * Class VideoGroupTest
 */
class VideoGroupTest extends HTML5VideoTest
{

    /**
     * Method that tests basic page creation
     * for VideoGroup.
     */
    public function testVideoGroupCreate()
    {
        $videoGroup = singleton('VideoGroup');
        $this->logInAs('JonDoe');

        $this->assertTrue($videoGroup->canCreate(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't add VideoGroup pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($videoGroup->canCreate(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can add VideoGroup pages but shouldn't be able to.");
        $this->logOut();
    }

    /**
     *
     */
    public function testVideoGroupEdit()
    {
        $videoGroup = $this->objFromFixture('VideoGroup', 'VideoGroupA');
        $this->logInAs('JonDoe');

        $this->assertTrue($videoGroup->canEdit(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't edit VideoGroup pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($videoGroup->canEdit(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can edit VideoGroup pages but shouldn't be able to.");
        $this->logOut();
    }

    /**
     *
     */
    public function testVideoGroupDelete()
    {
        $videoGroup = $this->objFromFixture('VideoGroup', 'VideoGroupA');
        $this->logInAs('JonDoe');

        $this->assertTrue($videoGroup->canDelete(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can't delete VideoGroup pages but should be able to.");
        $this->logOut();

        $this->logInAs('JaneDoe');
        $this->assertFalse($videoGroup->canDelete(Member::currentUser()),
            "Member " . Member::currentUser()->FirstName . " " . Member::currentUser()->Surname . " can delete VideoGroup pages but shouldn't be able to.");
        $this->logOut();
    }

    /**
     *
     */
    public function testChildGroups()
    {
        $videoGroup = $this->objFromFixture('VideoGroup', 'VideoGroupA');
        $childGroups = $videoGroup->getChildGroups()->column('ID');
        $allChildGroups = $videoGroup->getChildGroups(true)->column('ID');

        $shownChildGroups[] = $allChildGroupsManual[] = $this->objFromFixture('VideoGroup', 'VideoGroupC')->ID;
        $allChildGroupsManual[] = $this->objFromFixture('VideoGroup', 'VideoGroupD')->ID;

        $this->assertTrue(count($shownChildGroups) <= count($allChildGroupsManual),
            "The manual array of all child VideoGroup pages is smaller than the child VideoGroup pages. This shouldn't be the case");

        $inQueriedArray = function ($ID, $groupArray, $type) {
            $this->assertTrue(in_array($ID, $groupArray),
                "The VideoGroup with ID: {$ID} not found in the given VideoGroup ID array for {$type}.");
        };

        foreach ($childGroups as $key => $val) {
            $inQueriedArray($val, $shownChildGroups, 'children');
        }

        foreach ($allChildGroups as $key => $val) {
            $inQueriedArray($val, $allChildGroupsManual, 'all children');
        }
    }

    /**
     *
     */
    public function testVideoGroupIDs()
    {
        $shownChild = $this->objFromFixture('VideoGroup', 'VideoGroupC');
        $hiddenChild = $this->objFromFixture('VideoGroup', 'VideoGroupD');

        $shownArray[] = $shownChild->ID;
        $hiddenArray[] = $hiddenChild->ID;
        $hiddenArray = array_merge($hiddenArray, $shownArray);

        $mainGroup = $this->objFromFixture('VideoGroup', 'VideoGroupA');
        $shownSubGroupIDs = $mainGroup->getVideoGroupIDs();
        $hiddenSubGroupIDs = $mainGroup->getVideoGroupIDs(true);

        $checkShown = function ($ID) use (&$shownArray) {
            $this->assertTrue(in_array($ID, $shownArray),
                'Sub VideoGroup with ID: ' . $ID . ' not in children group array.');
        };

        $checkHidden = function ($ID) use (&$hiddenArray) {
            $this->assertTrue(in_array($ID, $hiddenArray),
                'Sub VideoGroup with ID: ' . $ID . ' not in all children group array.');
        };

        foreach ($shownSubGroupIDs as $key => $val) {
            $checkShown($val);
        }

        foreach ($hiddenSubGroupIDs as $key => $val) {
            $checkHidden($val);
        }
    }

    /**
     *
     */
    public function testGetVideoList()
    {
        $mainGroup = $this->objFromFixture('VideoGroup', 'VideoGroupA');
        $mainGroupVideos = $mainGroup->getVideoList()->column('ID');

        $videoList[] = $this->objFromFixture('Video', 'Video1')->ID;
        $videoList[] = $this->objFromFixture('Video', 'Video2')->ID;
        $videoList[] = $this->objFromFixture('Video', 'Video6')->ID;

        $inVideoArray = function ($ID) use (&$videoList) {
            $this->assertTrue(in_array($ID, $videoList),
                'The video list built manually doesn\'t have the ID: ' . $ID . ' in it.');
        };

        foreach ($mainGroupVideos as $key => $val) {
            $inVideoArray($val);
        }

    }

}