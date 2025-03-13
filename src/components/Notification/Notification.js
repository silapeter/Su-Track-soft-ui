import React, { useRef, forwardRef, useImperativeHandle } from "react";
import NotificationAlert from "react-notification-alert";

const Notification = forwardRef((props, ref) => {
    const notificationAlertRef = useRef(null);

    useImperativeHandle(ref, () => ({
        showNotification: (message, color, place = "tr") => {
            const options = {
                place: place,
                message: <div>{message}</div>,
                type: color,
                icon: "nc-icon nc-bell-55",
                autoDismiss: 7,
            };
            notificationAlertRef.current.notificationAlert(options);
        }
    }));

    return (
        <div className="rna-container">
            <NotificationAlert ref={notificationAlertRef} />
        </div>
    );
});

export default Notification;
