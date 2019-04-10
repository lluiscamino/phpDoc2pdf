<h2>Summary</h2>
<table>
    <tr>
        <th></th>
        <th>Methods</th>
        <th>Properties</th>
        <th>Constants</th>
    </tr>
    <tr>
        <td>Public</td>
        <td><?php echo ($methods['public'] !== '' ? $methods['public'] : '<em>No public methods found</em>') ?></td>
        <td><?php echo ($properties['public'] !== '' ? $properties['public'] : '<em>No public properties found</em>') ?></td>
        <td><?php echo ($constants['public'] !== '' ? $constants['public'] : '<em>No public constants found</em>') ?></td>
    </tr>
    <tr>
        <td>Protected</td>
        <td><?php echo ($methods['protected'] !== '' ? $methods['protected'] : '<em>No protected methods found</em>') ?></td>
        <td><?php echo ($properties['protected'] !== '' ? $properties['protected'] : '<em>No protected properties found</em>') ?></td>
        <td><em>N/A</em></td>
    </tr>
    <tr>
        <td>Private</td>
        <td><?php echo ($methods['private'] !== '' ? $methods['private'] : '<em>No private methods found</em>') ?></td>
        <td><?php echo ($properties['private'] !== '' ? $properties['private'] : '<em>No private properties found</em>') ?></td>
        <td><em>N/A</em></td>
    </tr>
</table>