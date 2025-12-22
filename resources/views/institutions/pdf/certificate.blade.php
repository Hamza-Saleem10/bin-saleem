<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School License</title>
   <style>
      @media print {
        .page-wrapper {
          page-break-after: always;
        }
      }
     
      
    </style>
  </head>
  <body
    style="
      font-family: Arial, Helvetica, sans-serif;
      line-height: 1.8;
      margin: 0;
      padding: 0;
      text-align: center;">
   
    <table
        style="
        width: 780px;
        height: 1100px; /* Adjust height to fit background */
        margin: 0 auto;
        padding: 0.3in;
        background-image: url('{{ asset('images/img.png') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-collapse: collapse;
        position: relative;
      "
      >
        <tbody>
          <tr>
            <td style="position: absolute;top: 36px;left: 21px;">
                <img src="{{ asset('images/QR.png') }}" alt="QR" style="width: 100px;margin: 39px 36px;">  
            </td>
          </tr>
          <tr>
            <td>
              <table style="width: 80%; border-collapse: collapse; color: navy; font-size: 18px; margin-top: 489px; margin-inline: 106px;">


                  <tr>
                      <td style="padding: 10px; text-align: left;">Owner Name </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><p>
                        <span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" > {{ optional($owner)->name }}</span>
                      </p></td>

                  </tr>
                  <tr>
                      <td style="padding: 10px; text-align: left;">CNIC Number </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" >{{ addDashesInCNIC(optional($owner)->cnic) }}</span></td>
                  </tr>
                  <tr>
                      <td style="padding: 10px; text-align: left;">School Gender </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" >{{ optional($institution)->institution_gender }}</span></td>
                  </tr>
                  <tr>
                      <td style="padding: 10px; text-align: left;">School Level </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" >{{ optional($institution)->institution_level }}</span></td>
                  </tr>
                  <tr>
                      <td style="padding: 10px; text-align: left;">Valid Till </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" >{{ date('F Y', strtotime(optional($institution)->license_end_date)) }}</span></td>
                  </tr>
                  <tr>
                      <td style="padding: 10px; text-align: left;">EMIS Code </td>
                      <td style="padding-inline: 39px;"><b>:</b></td>
                      <td><span style=" display: inline-block; min-width: 248px; border-bottom: 2px solid navy;line-height: 1;
                          min-height: 16px;text-align: center;" >{{ optional($institution)->emis_code }}</span></td>
                  </tr>
              </table>

            </td>
          </tr>    

        </tbody>
    <!-- </table> -->

      
      

     
    </table>

  </body>
</html>