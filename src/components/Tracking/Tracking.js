import { useState, useEffect } from "react";
import Modal from "@mui/material/Modal";
import Box from "@mui/material/Box";
import Card from "@mui/material/Card";
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";
import SoftInput from "components/SoftInput";
import SoftButton from "components/SoftButton";
import BasicLayout from "layouts/authentication/components/BasicLayout";
import curved6 from "assets/images/curved-images/curved0.jpg";
import useUniqueCodeGenerator from "components/CodeGen/CodeGan";


function Tracking() {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const generateCode = useUniqueCodeGenerator(7); // ใช้รหัส 7 หลัก
    const [code, setCode] = useState("");


    useEffect(() => {
        setCode(generateCode()); // เรียกใช้ generateCode() เมื่อ Component โหลดครั้งแรก
    }, []);

    return (
        <BasicLayout
            title="SU .. Document Track"
            description="ระบบติดตามเอกสาร นี้พัฒนาขึ้นตามโครงการพัฒนาศักยภาพผู้บริหารระดับกลางสายสนับสนุน ประจำปี 2568"
            image={curved6}
        >
            <Card>
                <SoftBox p={3} mb={1} textAlign="center">
                    <SoftTypography variant="h5" fontWeight="medium">
                        กรอกหมายเลขเอกสาร
                    </SoftTypography>
                </SoftBox>
                <SoftBox pt={2} pb={3} px={3}>
                    <SoftBox component="form" role="form">
                        <SoftBox mb={2}>
                            <SoftInput placeholder="หมายเลขเอกสาร" />
                        </SoftBox>
                        <SoftBox mt={4} mb={1}>
                            <SoftButton variant="gradient" color="dark" fullWidth onClick={handleOpen}>
                                ค้นหา
                            </SoftButton>
                        </SoftBox>
                    </SoftBox>
                </SoftBox>
            </Card>
            <Modal
                open={open}
                onClose={handleClose}
                BackdropProps={{
                    style: { backgroundColor: "rgba(255, 255, 255, 255)" } // พื้นหลังทึบสนิท
                }}
            >
                <Box
                    sx={{
                        position: "absolute",
                        top: "50%",
                        left: "50%",
                        transform: "translate(-50%, -50%)",
                        bgcolor: "white",
                        boxShadow: 24,
                        p: 4,
                        borderRadius: 2,
                        textAlign: "center",
                        width: "40%"
                    }}
                >
                    <SoftTypography variant="h4"> Code: {code}</SoftTypography>
                    <SoftBox mt={3}>
                        <div>
                            <h1>รหัสที่สร้าง: {code || "ยังไม่มีรหัส"}</h1>
                        </div>
                        <SoftButton variant="gradient" color="dark" onClick={handleClose}>
                            ปิด
                        </SoftButton>
                    </SoftBox>
                </Box>
            </Modal>
        </BasicLayout>
    );
}

export default Tracking;
