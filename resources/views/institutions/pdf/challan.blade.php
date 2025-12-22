<!DOCTYPE html>
<html>
  <head>
    <title>Fee Challan</title>
    <style>
      @media print {
        /* .page-wrapper {
          page-break-after: always;
        } */
      }

      @page{
        /* size: A4 portrait; */
        margin: 10mm 10mm 10mm 10mm;
      }
    </style>
  </head>
  <body
    style="
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      padding: 0;
      margin: 0;
    "
  >
    <table
      style="
       width: 700px;
        margin: 0 auto;
        border-collapse: collapse;
        font-size: 13px;
      "
    >
      <!-- Header -->
      <tr>
    <td style=" text-align: center; padding: 10px;">
      <img src="{{ asset('images/logo.png') }}" alt="Gov Logo" style="height: 100px;">
    </td>
    <td colspan="4" style="text-align: center; padding: 10px;">
      <span style="font-size: 26px; font-weight: bold;">SCHOOL EDUCATION DEPARTMENT</span><br>
      <span style="font-size: 20px; font-weight: bold;">GOVERNMENT OF GILGIT BALTISTAN</span><br>
      <span style="font-size: 20px; font-weight: bold;">e-school Gilgit Baltistan Application Fee Challan</span>
    </td>
  </tr>
  <tr>
    <td colspan="5" style="text-align: center; font-size: 13px; padding: 5px;">
      This is computer generated fee slip. Applications are considered only when processing fee is paid.
    </td>
  </tr>
      <!-- Applicant Copy -->
      @include('institutions.pdf.challan-detailes', ['title' => 'APPLICANT COPY'])

      <tr>
        <td colspan="5" style="height: 9px"></td>
      </tr>

      <!-- Department Copy -->

      @include('institutions.pdf.challan-detailes', ['title' => 'DEPARTMENT COPY'])

      <tr>
        <td colspan="5" style="height: 9px"></td>
      </tr>

      <!-- Bank Copy -->

        @include('institutions.pdf.challan-detailes', ['title' => 'BANK COPY'])

      <!-- Notes -->
      <tr>
        <td
          colspan="5"
          style="padding: 5px; font-size: 13px;"
        >
          <p style="margin-block: 5px;"><strong>A PSID (Payment Slip ID)</strong> will be automatically
          generated through the e-Pay Punjab system.</p>
          <p style="margin-block: 5px;">After generation of the challan, the fee can be paid through any Bank,
          E-Wallet, or One Link-enabled banking channel.</p>
          <p style="margin-block: 5px;"><strong>Payments</strong> must be made on or before the due date
          mentioned on the challan.</p>
          <p style="margin-block: 5px;">In case of late payment, a fine will be automatically applied as per
          the system’s rules and reflected in the updated challan.</p>
        </td>
      </tr>

      <!-- Seal -->
      <tr>
        <td colspan="5" style="text-align: center; padding: 10px">
          <img
            src="{{ asset('images/logo.png') }}"
            width="70"
          />
        </td>
      </tr>
    </table>
  </body>
</html>
