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


function Transactions(prop) {
  const docCode = prop.DocumentCode;
  const [trackingData, setTrackingData] = useState(null); // เก็บข้อมูล transaction
  const [loading, setLoading] = useState(true); // ใช้ตรวจสอบการโหลดข้อมูล
  const [error, setError] = useState(null); // ใช้เก็บ error (ถ้ามี)

  // ดึงข้อมูลจาก API เมื่อ component โหลด
  useEffect(() => {

    const getData = async () => {
  
      await axios
        .get(`${config.API_URL}track_db/track_get_details.php`, {
          params: {
            token: config.TOKEN,
          },
        })
        .then((res) => {

          setTrackingData(res.data.data); // เก็บข้อมูลที่ได้ลงใน state
          setLoading(false); // โหลดเสร็จแล้ว

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
          <SoftTypography variant="body2" color="text">ไม่พบข้อมูล</SoftTypography>
        ) : (<>
          <SoftBox display="flex" justifyContent="space-between" alignItems="center" pt={3} px={2}>
            <SoftTypography variant="h6" fontWeight="medium" textTransform="capitalize">
              เอกสารเลขที่ {docCode} เรื่อง ขออนุมัติทดสอบทดลอง สำนักงานอธิการบดี
            </SoftTypography>
          </SoftBox>
          <SoftBox mb={2}>
            <SoftTypography
              variant="caption"
              color="text"
              fontWeight="bold"
              textTransform="uppercase"
            >
              ความเคลื่อนไหว
            </SoftTypography>
          </SoftBox>
          <SoftBox component="ul" display="flex" flexDirection="column" p={0} m={0} sx={{ listStyle: "none" }}>
            {trackingData.map((Data, index) => (
              <Transaction
                key={index}
                color="info"
                icon="arrow_downward"
                name={Data.caption}
                description={Data.detail_}
                value={Data.date}
              />
            ))}
          </SoftBox>
        </>)}
      </SoftBox>
    </Card>
  );
}

export default Transactions;
