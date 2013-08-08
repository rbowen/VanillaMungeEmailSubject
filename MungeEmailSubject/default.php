<?php if (!defined('APPLICATION')) exit();

// Define the plugin:
$PluginInfo['MungeEmailSubject'] = array(
   'Name' => 'MungeEmailSubject',
   'Description' => 'Use the forum post title, rather than rubbish, for the email subject',
   'Version' => '0.1',
   'Author' => "Rich Bowen",
   'AuthorEmail' => 'rbowen@rcbowen.com',
   'AuthorUrl' => 'http://rcbowen.com',
   'MobileFriendly' => TRUE
);

// 0.1 - Just try to get a basic plugin working

class MungeEmailSubjectPlugin extends Gdn_Plugin {

    public function Setup() {
        // No setup required.
    }

    # Munge the email subject prior to sending
    public function ActivityModel_BeforeSendNotification_Handler($Sender) {
        $Email = $Sender->EventArguments['Email'];
        $User = $Sender->EventArguments['User'];
        $Activity = $Sender->EventArguments['Activity'];

        // Forum name ...
        $subj = preg_replace( '/] .*/', '] ', $Email->PhpMailer->Subject); 

        if ( $Activity->ActivityTypeID == 17 ) { # New post ... easy

            preg_match( '/^.*discussion\/(\d+)/', $Activity->Route, $matches );
            $DiscussionID = $matches[1];

            $DiscussionModel = new DiscussionModel();
            $Discussion = $DiscussionModel->GetID($DiscussionID);

            $Email->Subject( $subj . ' ' . $Discussion->Name );

        } 
        
        elseif ( $Activity->ActivityTypeID == 18 ) { # Comment ...  harder
            $title = 'COMMENT';
            $Email->Subject( $subj . ' ' . $title);

            preg_match( '/^.*discussion\/comment\/(\d+)/', $Activity->Route, $matches );
            $CommentID =  $matches[1];

            $CommentModel = new CommentModel();
            $Comment = $CommentModel->GetID( $CommentID );
            $DiscussionID = $Comment->DiscussionID;

            $DiscussionModel = new DiscussionModel();
            $Discussion = $DiscussionModel->GetID($DiscussionID);

            $Email->Subject( 'Re: ' . $subj . ' ' . $Discussion->Name );
        }

        else {
            // Leave the rest of them alone
        }

    }

}

