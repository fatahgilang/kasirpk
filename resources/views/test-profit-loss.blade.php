<!DOCTYPE html>
<html>
<head>
    <title>Test Profit Loss Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin: 10px 0; }
        .positive { color: green; }
        .negative { color: red; }
    </style>
</head>
<body>
    <h1>Test Profit Loss Report</h1>
    
    <div class="card">
        <h2>Summary</h2>
        <p><strong>Revenue:</strong> {{ $reportData['revenue']['formatted'] ?? 'Rp 0' }}</p>
        <p><strong>COGS:</strong> {{ $reportData['cost_of_goods_sold']['formatted'] ?? 'Rp 0' }}</p>
        <p><strong>Gross Profit:</strong> <span class="{{ ($reportData['gross_profit']['total'] ?? 0) >= 0 ? 'positive' : 'negative' }}">{{ $reportData['gross_profit']['formatted'] ?? 'Rp 0' }}</span></p>
        <p><strong>Net Profit:</strong> <span class="{{ ($reportData['net_profit']['total'] ?? 0) >= 0 ? 'positive' : 'negative' }}">{{ $reportData['net_profit']['formatted'] ?? 'Rp 0' }}</span></p>
        <p><strong>Profit Margin:</strong> {{ $reportData['profit_margin'] ?? 0 }}%</p>
    </div>
    
    <div class="card">
        <h2>Period</h2>
        <p>{{ $reportData['period']['start'] ?? '' }} - {{ $reportData['period']['end'] ?? '' }}</p>
    </div>
    
    <div class="card">
        <h2>Raw Data</h2>
        <pre>{{ print_r($reportData, true) }}</pre>
    </div>
</body>
</html>