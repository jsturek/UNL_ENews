<?php
class UNL_ENews_Newsletter_Preview extends UNL_ENews_LoginRequired
{
    /**
     * The newsletter
     * 
     * @var UNL_ENews_Newsletter
     */
    public $newsletter;
    
    public $available_stories;
    
    function __postConstruct()
    {
        if (isset($this->options['id'])) {
            $this->newsletter = UNL_ENews_Newsletter::getById($this->options['id']);
        } else {
            $this->newsletter = UNL_ENews_Newsletter::getLastModified();
        }
        if (!empty($_POST)) {
            $this->handlePost();
        }
        $this->available_stories = new UNL_ENews_Newsroom_UnpublishedStories(array('status'      => 'approved',
                                                                        'newsroom_id' => UNL_ENews_Controller::getUser(true)->newsroom->id,
                                                                        'limit'       => -1));
    }
    
    function handlePost()
    {
        $this->filterPostValues();
        switch($_POST['_type']) {
            case 'addstory':
                if (!isset($_POST['story_id'])) {
                    throw new Exception('invalid data, you must set the story_id', 400);
                }
                $this->addStory($_POST['story_id'], $_POST['sort_order'], $_POST['intro']);
                break;
            case 'removestory':
                if (!isset($_POST['story_id'])) {
                    throw new Exception('invalid data, you must set the story_id', 400);
                }
                $this->removeStory($_POST['story_id']);
                break;
            case 'newsletter':
                UNL_ENews_Controller::setObjectFromArray($this->newsletter, $_POST);
                $this->newsletter->save();
                break;
        }
    }
    
    function filterPostValues()
    {
        unset($_POST['newsroom_id']);
    }
    
    function removeStory($story_id)
    {
        if ($story = UNL_ENews_Story::getById($story_id)) {
            return $this->newsletter->removeStory($story);
        }
        return true;
    }
    
    function addStory($story_id, $sort_order = null, $intro = null)
    {
        if ($story = UNL_ENews_Story::getById($story_id)) {
            return $this->newsletter->addStory($story, $sort_order, $intro);
        }
        throw new Exception('could not add the story to the newsletter', 500);
    }
}