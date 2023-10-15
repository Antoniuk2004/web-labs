const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');

const app = express();

app.use('/getData', createProxyMiddleware({ 
  target: 'https://rozetka.com.ua',
  changeOrigin: true,
}));

const PORT = process.env.PORT || 5050;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
