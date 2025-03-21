import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import Card from "@mui/material/Card";
import Checkbox from "@mui/material/Checkbox";
import Modal from "@mui/material/Modal";
import Box from "@mui/material/Box";
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";
import SoftInput from "components/SoftInput";
import SoftButton from "components/SoftButton";
import BasicLayout from "layouts/authentication/components/BasicLayout";
import Socials from "layouts/authentication/components/Socials";
import Separator from "layouts/authentication/components/Separator/index2";
import curved6 from "assets/images/curved-images/curved14.jpg";
import config from "../../../config.json";
import emailjs from "emailjs-com";

import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";
import axios from "axios";

function SignUp() {
  const navigate = useNavigate();

  const sendEmail = (e) => {
    e.preventDefault();

    emailjs.send(
      "service_vpgp5m2",  // ใส่ Service ID จาก EmailJS
      "template_4us3tz6", // ใส่ Template ID
      formData,
      "oENL7Nnivp_ZDKTct"      // ใส่ User ID จาก EmailJS
    )
      .then(response => {
        console.log("Email sent successfully!", response);
        alert("Email sent successfully!");
        setFormData({ to_name: "", to_email: "", confirm_link: "", confirm_code: "" }); // เคลียร์ฟอร์ม
      })
      .catch(error => {
        console.error("Failed to send email:", error);
        alert("Failed to send email. Please try again.");
      });
  };


  const [agreement, setAgreement] = useState(true);
  const [openModal, setOpenModal] = useState(false);
  const [error, setError] = useState("");

  const [email, setEmail] = useState("");
  const [name, setName] = useState("");
  const [phone, setPhone] = useState("");

  const handleSetAgreement = () => setAgreement(!agreement);

  // State สำหรับแจ้งเตือน
  const [alertOpen, setAlertOpen] = useState(false);

  const ranDomCode = (length = 5) => {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      result += characters[randomIndex];
    }
    return result;
  }

  const regis = async () => {
    await axios
      .post(`${config.API_URL}user/regis.php`, {
        token: config.TOKEN,
        email: email,
        name: name,
        phone: phone,
        text: ranDomCode()

      })
      .then((r) => {
        setOpenModal(true)
      })
      .catch((e) => {
        console.log(e);
        return false;
      });
  };


  const checkExit = async () => {
    // console.log(currentUser)
    await axios
      .get(`${config.API_URL}user/checkexit.php`, {
        params: {
          token: config.TOKEN,
          email: email,
        }
      })
      .then((r) => {
        // console.log(r.data.found);
        if (r.data.found == 1) {
          setAlertOpen(true);
        } else {
          regis();
        }
      })
      .catch((e) => {
        console.log(e);
        return false;
      });
  }


  const handleSignUp = () => {
    if (!name.trim()) {
      setError("กรุณากรอกชื่อของท่าน");
      return;
    }
    if (!/^.+@silpakorn\.edu$/.test(email)) {
      setError("กรุณากรอกอีเมลที่ลงท้ายด้วย @silpakorn.edu");
      return;
    }
    if (!/^[0-9]{6}$/.test(phone)) {
      setError("กรุณากรอกเบอร์โทรภายในเป็นตัวเลข 6 หลัก");
      return;
    }
    if (!agreement) {  // ตรวจสอบว่าเช็คบ็อกซ์ถูกเลือกหรือไม่
      setError("เราไม่สามารถทำทำรายการได้หากท่านไม่ให้การยินยอมในการจัดเก็บข้อมูลส่วนบุคคลที่จำเป็น");
      return;
    } else {
      setError("");
      checkExit();
    }
  };


  const handleCloseModal = () => {
    setOpenModal(false);
    navigate("/");
  };

  return (
    <BasicLayout
      title="สมัครใช้บริการ"
      description="ระบบติดตามเอกสาร SU Document Tracking System เปิดให้บริการกับบุคลากรหน่วยงานภายในมหาวิทยาลัยศิลปากร ท่านสามารถสมัครใช้บริการด้วยการใช้อีเมล @silpakorn.edu ลงทะเบียนเพื่อใช้งาน"
      image={curved6}
    >
      <Card>
        <SoftBox p={3} mb={1} textAlign="center">
          <SoftTypography variant="h5" fontWeight="medium">
            Register with
          </SoftTypography>
        </SoftBox>
        <SoftBox mb={2}>
          <Socials />
        </SoftBox>
        <Separator />
        <SoftBox pt={2} pb={3} px={3}>
          <SoftBox component="form" role="form">
            <SoftBox mb={2}>
              <SoftInput placeholder="ชื่อภาษาไทย คำนำหน้า + ชื่อ + ชื่อกลาง (ถ้ามี) + นามสกุล ตย. นายสมมติ ไม่มีจริง" value={name} onChange={(e) => setName(e.target.value)} />
            </SoftBox>
            <SoftBox mb={2}>
              <SoftInput
                type="email"
                placeholder="อีเมล @silpakorn.edu ตย. maimeejing_s@silpakorn.edu"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </SoftBox>
            <SoftBox mb={2}>
              <SoftInput
                type="เบอร์โทรภายในที่ติดต่อได้"
                placeholder="เบอร์โทรภายใน (6 หลัก)"
                value={phone}
                onChange={(e) => {
                  if (/^[0-9]*$/.test(e.target.value) && e.target.value.length <= 6) {
                    setPhone(e.target.value);
                  }
                }}
              />
            </SoftBox>
            {error && <SoftTypography color="error">{error}</SoftTypography>}

            <SoftBox display="flex" alignItems="center">
              <Checkbox checked={agreement} onChange={handleSetAgreement} />
              <SoftTypography
                variant="button"
                fontWeight="regular"
                onClick={handleSetAgreement}
                sx={{ cursor: "pointer", userSelect: "none" }}
              >
                &nbsp;&nbsp;ท่านยินยอมให้ระบบจัดเก็บ&nbsp;
              </SoftTypography>
              <SoftTypography component="a" href="#" variant="button" fontWeight="bold" textGradient>
                ชื่อ, อีเมล และเบอร์โทรของท่าน
              </SoftTypography>
            </SoftBox>
            <SoftBox mt={4} mb={1}>
              <SoftButton variant="gradient" color="dark" fullWidth onClick={handleSignUp}>
                sign up
              </SoftButton>
            </SoftBox>
            <SoftBox mt={3} textAlign="center">
              <SoftTypography variant="button" color="text" fontWeight="regular">
                Already have an account?&nbsp;
                <SoftTypography component={Link} to="/authentication/sign-in" variant="button" color="dark" fontWeight="bold" textGradient>
                  Sign in
                </SoftTypography>
              </SoftTypography>
            </SoftBox>
          </SoftBox>
        </SoftBox>
      </Card>

      {/* Modal */}
      <Modal open={openModal} onClose={handleCloseModal}>
        <Box
          sx={{
            position: "absolute",
            top: "50%",
            left: "50%",
            transform: "translate(-50%, -50%)",
            width: 400,
            bgcolor: "background.paper",
            boxShadow: 24,
            p: 4,
            textAlign: "center",
            borderRadius: 2,
          }}
        >
          <SoftTypography variant="h6" fontWeight="bold">
            กรุณาเปิดอีเมล {email}
          </SoftTypography>
          <SoftTypography variant="h6" fontWeight="bold">
            และคลิกลิงก์ยืนยันการสมัคร
          </SoftTypography>
          {/* <SoftBox mb={3}>
            <SoftInput placeholder="รหัสยืนยัน" />
          </SoftBox> */}
          <SoftBox mt={3} display="flex" justifyContent="center">
            <SoftButton variant="gradient" color="success" onClick={handleCloseModal}>
              ยืนยัน
            </SoftButton>
          </SoftBox>
          <SoftTypography variant="body2"  mt={4}>
            คลิกปุ่มยืนยันเพื่อกลับสู่หน้าหลัก
          </SoftTypography>
        </Box>
      </Modal>
      {/* Snackbar แจ้งเตือนเมื่อไม่ได้กรอกหมายเลขเอกสาร */}
      <Snackbar
        open={alertOpen}
        autoHideDuration={3000} // ปิดอัตโนมัติใน 3 วินาที
        onClose={() => setAlertOpen(false)}
        anchorOrigin={{ vertical: "top", horizontal: "center" }} // ตำแหน่งของแจ้งเตือน
      >
        <MuiAlert severity="error" sx={{ width: "100%" }} onClose={() => setAlertOpen(false)}>
          อีเมลนี้มีการใช้งานแล้ว
        </MuiAlert>
      </Snackbar>
    </BasicLayout>
  );
}

export default SignUp;
