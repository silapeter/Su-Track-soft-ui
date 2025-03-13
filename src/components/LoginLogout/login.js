import React, { useContext, useState, useEffect } from "react";
// import GoogleLogin from "react-google-login";
// import gLogin from "../../GoogleLogin.json";
import { AuthContext } from "auth/auth.js";
import axios from "axios";
import configData from "config.json";
import { useGoogleLogin } from "@react-oauth/google";
import GoogleButton from "react-google-button";
import Notification from "components/Notification/Notification";

function Login(props) {
  const notificationRef = useRef(null);
  const handleShowNotification = (msg,color) => {
    if (notificationRef.current) {
      notificationRef.current.showNotification("This is a triggered notification!", "success");
    }
  };
  const loginApi = `${configData.API_URL}login/admin_login.php`;
  const token_config = configData.TOKEN;

  const durationApi = configData.API_URL + "duration_db/get_active.php";
  const [currentDuration, setDuration] = useState([]);
  const [systemStatus, setSystemStatus] = useState(false);

  const get_duration = () => {
    axios
      .get(`${durationApi}`, {
        params: {
          token: token_config,
        },
      })
      .then((Response) => {
        if (Response.data) {
          setSystemStatus(true);
          setDuration({
            start_: Response.data["start_"],
            end_: Response.data["end_"],
            name_: Response.data["name_"],
            id_: Response.data["id_"],
            master_: Response.data['master_'],
          })
        } else {
          setSystemStatus(false);
        }
      })
  }



  const login = useGoogleLogin({
    onSuccess: (tokenResponse) => onSuccess(tokenResponse),
    onError: (error) => onFailure(error),
  });

  const loginCheck = (resp_data, token) => {
    // console.log(resp_data);

    axios
      .get(loginApi, {
        params: {
          user_email: resp_data.email,
          token: token_config,
        },
      })
      .then((Response) => {
        // console.log(Response.data)
        if (Response.data.login == 1) {
       
          setCurrentUser({
            usr_data: Response.data.userdata,
            google_data: resp_data,
            current_data: currentDuration,
            system_status: systemStatus,
            loginstatus: 1,
            token: token,
          });
          // console.log(resp_data, Response.data.userdata);
        } else {
          // console.log(Response.data)
          handleShowNotification(
            "โปรแกรมส่วนนี้สำหรับผู้ดูแลระบบเท่านั้น","warning"
          );
        }
      })
      .catch((err) => {
        handleShowNotification("Failure " + err, "danger");
        // console.log(err);
      });

    // console.log(update);
  };

  const { currentUser, setCurrentUser } = useContext(AuthContext);
  // console.log(gLogin);

  const onSuccess = (tokenResponse) => {
    axios
      .get(
        `https://www.googleapis.com/oauth2/v1/userinfo?access_token=${tokenResponse.access_token}`,
        {
          headers: {
            Authorization: `Bearer ${tokenResponse.access_token}`,
            Accept: "application/json",
          },
        }
      )
      .then((res) => {
        //  setProfile(res.data);
        // props.reDir(true);
        loginCheck(res.data, tokenResponse);
      })
      .catch((err) => console.log(err));
  };
  const onFailure = (Response) => {
    handleShowNotification("เข้าสู่ระบบไม่สำเร็จกรุณาตรวจสอบ :" + Response , "warning");
    // console.log("login Failure! Current User : ", Response.profileObj);
  };

  useEffect(() => {
    get_duration();
  }, []);

  return (
    <>
      <Notification ref={notificationRef} />
      <div>
        <GoogleButton onClick={() => login()} />
      </div>
      <br />
      <div>

      </div>
    </>
  );
}

export default Login;
