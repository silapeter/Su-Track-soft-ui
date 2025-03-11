/**
=========================================================
* Soft UI Dashboard React - v4.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-react
* Copyright 2023 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

// @mui material components
import Card from "@mui/material/Card";
import Icon from "@mui/material/Icon";

// Soft UI Dashboard React components
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";

// Soft UI Dashboard React examples
import TimelineItem from "examples/Timeline/TimelineItem";

function OrdersOverview() {
  return (
    <Card className="h-100">
      <SoftBox pt={3} px={3}>
        <SoftTypography variant="h6" fontWeight="medium">
          สถานะเอกสาร
        </SoftTypography>
        <SoftBox mt={1} mb={2}>
          <SoftTypography variant="button" color="text" fontWeight="regular">
            <SoftTypography display="inline" variant="body2" verticalAlign="middle">
              {/* <Icon sx={{ fontWeight: "bold", color: ({ palette: { success } }) => success.main }}>
                arrow_upward
              </Icon> */}
            </SoftTypography>
            {/* <SoftTypography variant="button" color="text" fontWeight="medium">
              24%
            </SoftTypography>{" "} */}
            การเคลื่อนไหวของเอกสาร
          </SoftTypography>
        </SoftBox>
      </SoftBox>
      <SoftBox p={2}>
        <TimelineItem
          color="success"
          icon="notifications"
          title="เข้าระบบ (คณะสมมติ : pikajuu_s)"
          dateTime="20 DEC 7:20 PM"
        />
        <TimelineItem
          color="info"
          icon="payment"
          title="กองกลาง (sommutt_s)"
          dateTime="21 DEC 9:34 PM"
        />
        <TimelineItem
          color="warning"
          icon="payment"
          title="เลขารองวิชาการ (maimeejing_s)"
          dateTime="22 DEC 2:20 AM"
        />
        <TimelineItem
          color="primary"
          icon="vpn_key"
          title="คณะสมมติ (pikajuu_s)"
          dateTime="23 DEC 4:54 AM"
        />
      </SoftBox>
    </Card>
  );
}

export default OrdersOverview;
