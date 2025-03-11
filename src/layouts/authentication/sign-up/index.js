import { useState } from "react";
import { Link } from "react-router-dom";
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

function SignUp() {
  const [agreement, setAgreement] = useState(true);
  const [openModal, setOpenModal] = useState(false);
  const [email, setEmail] = useState("");
  const [name, setName] = useState("");
  const [phone, setPhone] = useState("");
  const [error, setError] = useState("");

  const handleSetAgreement = () => setAgreement(!agreement);

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
    setError("");
    setOpenModal(true);
  };

  const handleCloseModal = () => setOpenModal(false);

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
              <SoftInput placeholder="Name" value={name} onChange={(e) => setName(e.target.value)} />
            </SoftBox>
            <SoftBox mb={2}>
              <SoftInput
                type="email"
                placeholder="Email @silpakorn.edu"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </SoftBox>
            <SoftBox mb={2}>
              <SoftInput
                type="text"
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
            กรุณาเปิดอีเมลที่ท่านใช้สมัครใช้บริการ และกรอกรหัสยืนยันที่ท่านได้ทางอีเมลในช่องด้านล่าง
          </SoftTypography>
          <SoftBox mb={3}>
            <SoftInput placeholder="รหัสยืนยัน" />
          </SoftBox>
          <SoftBox mt={3} display="flex" justifyContent="space-between">
            <SoftButton variant="gradient" color="dark" onClick={handleCloseModal}>
              ยืนยัน
            </SoftButton>
            <SoftButton variant="gradient" color="warning" onClick={handleCloseModal}>
              ยกเลิก
            </SoftButton>
          </SoftBox>
        </Box>
      </Modal>
    </BasicLayout>
  );
}

export default SignUp;
