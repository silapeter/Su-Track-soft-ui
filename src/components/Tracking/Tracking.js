import { useState} from "react";
// import Modal from "@mui/material/Modal";
// import Box from "@mui/material/Box";
import Card from "@mui/material/Card";
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";
import SoftInput from "components/SoftInput";
import SoftButton from "components/SoftButton";
import BasicLayout from "layouts/authentication/components/BasicLayout";
import curved6 from "assets/images/2895860.jpg";
// import useUniqueCodeGenerator from "components/CodeGen/CodeGan";
import Transactions from "layouts/billing/components/Transactions";

// @mui material components
import Grid from "@mui/material/Grid";
import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";

function Tracking() {

    const [opentrans, setOpentrans] = useState(false);
    const [DocumentCode, setDocumentCode] = useState("");

    // const generateCode = useUniqueCodeGenerator(7); // ใช้รหัส 7 หลัก
    // const [code, setCode] = useState("");

    // State สำหรับแจ้งเตือน
    const [alertOpen, setAlertOpen] = useState(false);

    // useEffect(() => {
    //     setCode(generateCode()); // เรียกใช้ generateCode() เมื่อ Component โหลดครั้งแรก
    // }, []);

    const handleOpentrans = () => {
        if (!DocumentCode.trim()) {

            setAlertOpen(true); // เปิดแจ้งเตือนเมื่อไม่ได้กรอกหมายเลขเอกสาร
            setOpentrans(false);
            return;
        }
        setOpentrans(true);
    };
    // console.log("DocumentCode: ");
    return (
        <>
            <BasicLayout
                title="SU .. Document Track"
                description="ระบบติดตามเอกสาร"
                image={curved6}
            >
                <Grid container spacing={3}>
                    <Grid item xs={12} md={12}>
                        <Card>
                            <SoftBox p={3} mb={1} textAlign="center">
                                <SoftTypography variant="h5" fontWeight="medium">
                                    กรอกหมายเลขเอกสาร
                                </SoftTypography>
                            </SoftBox>
                            <SoftBox pt={2} pb={3} px={3}>
                                <SoftBox component="form" role="form">
                                    <SoftBox mb={2}>
                                        <SoftInput
                                            placeholder="หมายเลขเอกสาร"
                                            value={DocumentCode}
                                            onChange={(e) => setDocumentCode(e.target.value)}
                                        />
                                    </SoftBox>
                                    <SoftBox mt={4} mb={1}>
                                        <SoftButton variant="gradient" color="dark" fullWidth onClick={handleOpentrans}>
                                            ค้นหา
                                        </SoftButton>
                                    </SoftBox>
                                </SoftBox>
                            </SoftBox>
                        </Card>
                    </Grid>

                    {opentrans ? (
                        <Grid item xs={12} md={12}>
                            <Transactions DocumentCode={DocumentCode} />
                        </Grid>
                    ) : null}
                </Grid>


                {/* Snackbar แจ้งเตือนเมื่อไม่ได้กรอกหมายเลขเอกสาร */}
                <Snackbar
                    open={alertOpen}
                    autoHideDuration={3000} // ปิดอัตโนมัติใน 3 วินาที
                    onClose={() => setAlertOpen(false)}
                    anchorOrigin={{ vertical: "top", horizontal: "center" }} // ตำแหน่งของแจ้งเตือน
                >
                    <MuiAlert severity="warning" sx={{ width: "100%" }} onClose={() => setAlertOpen(false)}>
                        กรุณากรอกหมายเลขเอกสาร
                    </MuiAlert>
                </Snackbar>
            </BasicLayout>
        </>
    );
}
 
export default Tracking;
