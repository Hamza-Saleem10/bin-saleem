<tr>
    <td
        rowspan="7"
        style="
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        font-weight: bold;
        text-align: center;
        border: 1px solid black;
        /* padding: 10px; */
        "
    >
        {{ $title }}
    </td>
    <td style="border: 1px solid black; padding: 4px">PSID Expiry Date</td>
    <td style="border: 1px solid black; padding: 4px">{{ date('d-m-Y', strtotime($challan->expiry_date)) }}</td>
    <td style="border: 1px solid black; padding: 4px">PSID Number</td>
    <td style="border: 1px solid black; padding: 4px">{{ $challan->psid }}</td>
</tr>
<tr>
    <td style="border: 1px solid black; padding: 4px">Applicant Name</td>
    <td style="border: 1px solid black; padding: 4px">{{ optional($owner)->name }}</td>
    <td style="border: 1px solid black; padding: 4px">Cell No</td>
    <td style="border: 1px solid black; padding: 4px">{{ optional($owner)->mobile }}</td>
</tr>
<tr>
    <td style="border: 1px solid black; padding: 4px">CNIC</td>
    <td style="border: 1px solid black; padding: 4px">{{ addDashesInCNIC(optional(optional(optional($challan)->institution)->user)->cnic) }}</td>
    <td style="border: 1px solid black; padding: 4px">Print Date</td>
    <td style="border: 1px solid black; padding: 4px">{{ date('d-m-Y') }}</td>
</tr>
<tr>
    <td style="border: 1px solid black; padding: 4px">School Name</td>
    <td style="border: 1px solid black; padding: 4px">
        {{ optional(optional($challan)->institution)->name }}
    </td>
    <td style="border: 1px solid black; padding: 4px">School Level</td>
    <td style="border: 1px solid black; padding: 4px">{{ optional(optional($challan)->institution)->institution_level }}</td>
</tr>
<tr>
    <td
        rowspan="2" colspan="2"
        style="border: 1px solid black; padding: 4px; font-weight: bold"
    ></td>
    <td style="border: 1px solid black; padding: 4px; font-weight: bold;">Fee</td>

    <td style="border: 1px solid black; padding: 4px; font-weight: bold;" colspan="2">
        Amount (Pak Rupees).
    </td>
</tr>
<tr>
    <td style="border: 1px solid black; padding: 4px">Application Processing Fee</td>
    <td
        style="border: 1px solid black; padding: 4px; font-weight: bold"
        colspan="2"
    >
        {{ number_format($challan->total_fee) }}
    </td>
</tr>
<tr>
    <td
        colspan="2"
        style="
        border: 1px solid black;
        padding: 5px;
        font-weight: bold;
        text-align: center;
        "
    >
        Bank Official’s Signature & Bank Stamp
    </td>
    <td
        colspan="2"
        style="border: 1px solid black; padding: 5px; text-align: center"
    >
        {{ numberToWords($challan->total_fee) }} Only -/
    </td>
</tr>
