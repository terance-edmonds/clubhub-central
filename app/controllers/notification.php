<?php

class Notification extends Controller
{
    public function index()
    {
        $notifications = [];

        if (Auth::logged()) {
            $user_notifications = new UserNotifications();
            $notifications = $user_notifications->find([
                "notification_state.user_id" => Auth::getId()
            ], ["user_notifications.id as id", "title", "description", "notification_state.id as notification_state_id", "notification_state.mark_as_read"],  [
                ["table" => "user_notification_state", "as" => "notification_state", "on" => "user_notifications.id = notification_state.notification_id"]
            ]);
        }

        echo `<results>$notifications<results>`;
    }

    public function read()
    {
        $user_notification_state = new UserNotificationsState();

        $user_notification_state->update([
            "id" => $_POST['id']
        ], [
            "mark_as_read" => 1
        ]);

        echo "success";
    }

    public function delete()
    {
        $user_notification_state = new UserNotificationsState();

        $user_notification_state->delete([
            "id" => $_POST['id']
        ]);

        echo "success";
    }
}
