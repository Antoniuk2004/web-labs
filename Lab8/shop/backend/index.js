const express = require('express');
const app = express();
const cors = require('cors');

const port = 7070;
const { getData, inputData } = require('./database');

app.use(cors());
app.use(express.json());
app.use('/images', express.static('images'));

app.get('/getData', async (req, res) => {
    try {
        const name = req.query.name;

        const data = await getData(name);
        res.status(200).json({ success: true, data: data });
    } catch (error) {
        res.status(500).json({ success: false, error: 'Internal Server Error' });
    }
});


app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});