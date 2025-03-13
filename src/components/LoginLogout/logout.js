import GoogleLogout from "react-google-login";

import googleLogin from "../../GoogleLogin.json";
// const clientId =
//   "838115570879-b13m5lhctvqfjivmb9i7voeo0b5cabfb.apps.googleusercontent.com";

  function Logout(){
        const onSuccess = (Response) => {
          console.log("Logout Success! Current User : ", Response.profileObj);
        };
        const onFailure = (Response) => {
          console.log("logout Failure! Current User : ", Response.profileObj);
        };
        return (
          <div id="signInButton">
            <GoogleLogout
              clientId={googleLogin.web.client_id}
              buttonText="ออกจากระบบ"
              onSuccess={onSuccess}
              onFailure={onFailure}
              cookiePolicy={"single_host_origin"}
              isSignedIn={true}
            />
          </div>
        );
  }

  export default Logout;