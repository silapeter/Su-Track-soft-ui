import { useState, useEffect } from "react";
import axios from "axios";

// @mui material components
import Card from "@mui/material/Card";

// Soft UI Dashboard React components
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";

// Billing page components
import Transaction from "layouts/billing/components/Transaction";
import config from "../../../../config.json";
import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";


function Transactions(prop) {
  const docCode = prop.DocumentCode;
  const [trackingData, setTrackingData] = useState(null); // เก็บข้อมูล transaction
  const [itemData, setItemData] = useState(null); // เก็บข้อมูล transaction
  const [loading, setLoading] = useState(true); // ใช้ตรวจสอบการโหลดข้อมูล
  const [error, setError] = useState(null); // ใช้เก็บ error (ถ้ามี)
  const [alertOpen, setAlertOpen] = useState(false);

  // ดึงข้อมูลจาก API เมื่อ component โหลด
  useEffect(() => {

    const getData = async () => {

      await axios
        .get(`${config.API_URL}track_db/track_get_details.php`, {
          params: {
            itemCode: docCode,
            token: config.TOKEN,
          },
        })
        .then((res) => {
          setItemData(res.data.detail); // เก็บข้อมูลรายละเอียด item ที่ได้ลงใน state
          setTrackingData(res.data.data); // เก็บข้อมูลความเคลื่อนไหวที่ได้ลงใน state
          setLoading(false); // โหลดเสร็จแล้ว
          // setAlertOpen(true); // เปิดแจ้งเตือนเมื่อไม่พบข้อมูล

        })
        .catch((err) => {
          setError(err.message); // ถ้ามี error ให้เก็บไว้ใน state
          setLoading(false); // โหลดเสร็จแล้ว

        });
    }


    getData(); // เรียกใช้ฟังก์ชันดึงข้อมูล

  }, [docCode]);

  return (
    <Card sx={{ height: "100%" }}>


      <SoftBox pt={3} pb={2} px={2}>


        {loading ? (
          <SoftTypography variant="body2" color="text">กำลังโหลดข้อมูล...</SoftTypography>
        ) : error ? (
          <SoftTypography variant="body2" color="error">เกิดข้อผิดพลาด: {error}</SoftTypography>
        ) : trackingData.length === 0 ? (
          <>
            <SoftTypography variant="body2" color="text">ไม่พบข้อมูล</SoftTypography>
          </>
        ) : (<>
          <SoftBox display="flex" justifyContent="space-between" alignItems="center" pt={3} px={2}>
                  <SoftTypography variant="h6" fontWeight="medium" textTransform="capitalize">
                    <span style={{ color: '#3F51B5' }}>เอกสารเลขที่</span> {docCode}
                    <span style={{ color: '#3F51B5' }}> เรื่อง</span>  {itemData?.icaption_}
                  </SoftTypography>
          </SoftBox>
          <SoftBox display="flex" justifyContent="space-between" alignItems="center" pt={2} px={2} ml={2}>
            <SoftTypography variant="h6" fontWeight="medium" textTransform="capitalize">
              รายละเอียด {itemData?.idetail_}
            </SoftTypography>
          </SoftBox>
          <SoftBox display="flex" justifyContent="space-between" alignItems="center" pt={1} px={2} ml={2}>
            <SoftTypography variant="h6" fontWeight="medium" textTransform="capitalize">
                    ผู้บันทึก {itemData?.user_email} ({itemData?.dept_name}) 
            </SoftTypography>
          </SoftBox>
                <SoftBox display="flex" justifyContent="space-between" alignItems="center" pt={1} px={2} ml={2}>
                  <SoftTypography variant="h6" fontWeight="medium" textTransform="capitalize">
                    {`วันที่ ${new Date(itemData?.idate_).toLocaleString("th-TH", {
                      year: "numeric",
                      month: "long",
                      day: "numeric",
                      hour: "2-digit",
                      minute: "2-digit",
                      second: "2-digit"
                    })}`}
                  </SoftTypography>
                </SoftBox>

          <SoftBox mb={2} mt={3} ml={3} >
            <SoftTypography
              variant="caption"
              color="text"
              fontWeight="bold"
              textTransform="uppercase"
            >
              Tracking Status
            </SoftTypography>
          </SoftBox>
          <SoftBox component="ul" display="flex" flexDirection="column" p={0} m={0} sx={{ listStyle: "none" }} ml={3}>
            {trackingData.map((Data, index) => (
              <Transaction
                key={index}
                color={Data.detail_ == "บันทึกเข้าสู่ระบบ" ? "success"  : index == 0 ? "info" : "warning"}
                icon={Data.detail_ == "บันทึกเข้าสู่ระบบ" ? "home" : index == 0 ? "star" : "arrow_upward"}
                name={Data.detail_}
                description={Data.dept_name + " (" + Data.user_email + ")"}
                value={`วันที่ ${new Date(Data.timestamp).toLocaleString("th-TH", {
                  year: "numeric",
                  month: "long",
                  day: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
                  second: "2-digit"
                })}`}
              />
            ))}
          </SoftBox>
        </>)}
        {/* Snackbar แจ้งเตือนเมื่อไม่ได้กรอกหมายเลขเอกสาร */}
        <Snackbar
          open={alertOpen}
          autoHideDuration={3000} // ปิดอัตโนมัติใน 3 วินาที
          onClose={() => setAlertOpen(false)}
          anchorOrigin={{ vertical: "top", horizontal: "center" }} // ตำแหน่งของแจ้งเตือน
        >
          <MuiAlert severity="warning" sx={{ width: "100%" }} onClose={() => setAlertOpen(false)}>
            ไม่พบข้อมูล
          </MuiAlert>
        </Snackbar>
      </SoftBox>
    </Card>
  );
}

export default Transactions;