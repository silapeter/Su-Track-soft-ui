// @mui material components
import Tooltip from "@mui/material/Tooltip";

// Soft UI Dashboard React components
import SoftBox from "components/SoftBox";
import SoftTypography from "components/SoftTypography";
import SoftAvatar from "components/SoftAvatar";
import SoftProgress from "components/SoftProgress";

// Images
import logoXD from "assets/images/small-logos/logo-xd.svg";
import logoAtlassian from "assets/images/small-logos/logo-atlassian.svg";
import logoSlack from "assets/images/small-logos/logo-slack.svg";
import logoSpotify from "assets/images/small-logos/logo-spotify.svg";
import logoJira from "assets/images/small-logos/logo-jira.svg";
import logoInvesion from "assets/images/small-logos/logo-invision.svg";
import team1 from "assets/images/team-1.jpg";
import team2 from "assets/images/team-2.jpg";
import team3 from "assets/images/team-3.jpg";
import team4 from "assets/images/team-4.jpg";

export default function data() {
  const avatars = (related) =>
    related.map(([image, name]) => (
      <Tooltip key={name} title={name} placeholder="bottom">
        <SoftAvatar
          src={image}
          alt="name"
          size="xs"
          sx={{
            border: ({ borders: { borderWidth }, palette: { white } }) =>
              `${borderWidth[2]} solid ${white.main}`,
            cursor: "pointer",
            position: "relative",

            "&:not(:first-of-type)": {
              ml: -1.25,
            },

            "&:hover, &:focus": {
              zIndex: "10",
            },
          }}
        />
      </Tooltip>
    ));

  return {
    columns: [
      { name: "subject", align: "left" },
      { name: "related", align: "left" },
      { name: "office", align: "left" },
      { name: "owner", align: "left" },
    ],

    rows: [
      {
        subject: [logoXD, "คำสั่งที่ 666/2575 เรื่อง แต่งตั้งผู้รักษาการแทนรองอธิการบดีฝ่ายกิจการนักศึกษา ผู้ช่วยศาสตราจารย์ ดร.สมมติ ไม่มีจริง"],
        related: (
          <SoftBox display="flex" py={1}>
            {avatars([
              [team1, "Ryan Tompson"],
              [team2, "Romina Hadid"],
              [team3, "Alexander Smith"],
              [team4, "Jessica Doe"],
            ])}
          </SoftBox>
        ),
        office: (
          <SoftTypography variant="caption" color="text" fontWeight="medium">
            สำนักงานอธิการบดี
          </SoftTypography>
        ),
        owner: (
          <SoftBox width="8rem" textAlign="left">
            sungjuic_w
            {/* <SoftProgress value={60} color="info" variant="gradient" label={false} /> */}
          </SoftBox>
        ),
      },
      {
        subject: [logoAtlassian, "ขอเชิญเข้าร่วมโครงการประชุมวิชาการ หัวข้อ นวัตกรรมและเทคโนโลยีกับการบริหารเพื่อการสร้างสรรค์อย่างยั่งยืน"],
        related: (
          <SoftBox display="flex" py={1}>
            {avatars([
              [team2, "Romina Hadid"],
              [team4, "Jessica Doe"],
            ])}
          </SoftBox>
        ),
        office: (
          <SoftTypography variant="caption" color="text" fontWeight="medium">
            สำนักดิจิทัลเทคโนโลยี
          </SoftTypography>
        ),
        owner: (
          <SoftBox width="8rem" textAlign="left">
            sampleemail_s
            {/* <SoftProgress value={10} color="info" variant="gradient" label={false} /> */}
          </SoftBox>
        ),
      },
      {
        subject: [logoSlack, "มาตรการด้านความปลอดภัยภายในวิทยาเขตพระราชวังสนามจันทร์งานพิธีพระราชทานปริญญาบัตรประจำปีการศึกษา 2566 "],
        related: (
          <SoftBox display="flex" py={1}>
            {avatars([
              [team1, "Ryan Tompson"],
              [team3, "Alexander Smith"],
            ])}
          </SoftBox>
        ),
        office: (
          <SoftTypography variant="caption" color="text" fontWeight="medium">
            กองกลาง
          </SoftTypography>
        ),
        owner: (
          <SoftBox width="8rem" textAlign="left">
            sommutt_m
            {/* <SoftProgress value={100} color="success" variant="gradient" label={false} /> */}
          </SoftBox>
        ),
      },
    ],
  };
}
