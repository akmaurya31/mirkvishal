<?php 
    $this->db->where('payment_type', 'expense');
    
    $this->db->where('payment_id', $param2); // Change ID dynamically as needed
    $expense = $this->db->get('payment')->row_array();
?>

<script>
    function PrintElem(elem) {
        var content = document.querySelector(elem).innerHTML;
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        mywindow.document.write('<html><head><title>Expense Slip</title></head><body>');
        mywindow.document.write(content);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        return true;
    }
</script>

<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default">
        Print Invoice
    </a>
</center>

<br>

<div id="invoice_print">
<?php if ($expense): ?>
    <table width="100%" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">
        <tr>
            <th colspan="2" style="text-align: center; font-size: 18px;">Expense Slip</th>
        </tr>
        <tr>
            <td><strong>Creation Date</strong></td>
            <td><?= date('d M, Y', $expense['timestamp']); ?></td>
        </tr>
        <tr>
            <td><strong>Title</strong></td>
            <td><?= $expense['title']; ?></td>
        </tr>
        
        <tr>
            <td><strong>Description</strong></td>
            <td><?= $expense['description']; ?></td>
        </tr>
        <tr>
            <td><strong>Amount</strong></td>
            <td><?= number_format($expense['amount'], 2); ?></td>
        </tr>
        <tr>
            <td><strong>Method</strong></td>
            <td><?= $expense['method']; ?></td>
        </tr>
        
        <tr>
            <td><strong>Date</strong></td>
            <td><?= date('d M Y', $expense['timestamp']); ?></td>
        </tr>
    </table>
<?php else: ?>
    <p style="text-align: center;">No expense found.</p>
<?php endif; ?>
</div>
