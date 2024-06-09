const express = require('express');
const bodyParser = require('body-parser');
const jwt = require('jsonwebtoken');
const mysql = require('mysql2');
const crypto = require('crypto');
const path = require('path');

const app = express();
const port = 3000;
const SECRET_KEY = 'Tuinhek12!'; // Replace with your actual secret key

app.use(bodyParser.json());
app.use(express.static(__dirname));

// Serve HTML files dynamically
app.get('*', (req, res) => {
  const requestedPath = path.join(__dirname, req.path);
  
  // Check if the requested path is a file and exists
  fs.stat(requestedPath, (err, stats) => {
    if (!err && stats.isFile()) {
      res.sendFile(requestedPath);
    } else if (!err && stats.isDirectory()) {
      // If a directory is requested, try to serve index.html within it
      const indexPath = path.join(requestedPath, 'sign-up.html');
      fs.access(indexPath, fs.constants.F_OK, (indexErr) => {
        if (!indexErr) {
          res.sendFile(indexPath);
        } else {
          res.status(404).send('404 Not Found');
        }
      });
    } else {
      res.status(404).send('404 Not Found');
    }
  });
});

// MySQL connection setup
const db = mysql.createConnection({
  host: 'localhost',  // Your MySQL host
  user: 'root',       // Your MySQL user
  password: 'Tuinhek12!', // Your MySQL password
  database: 'webshop' // Your MySQL database
});

db.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err);
    return;
  }
  console.log('Connected to MySQL');
});

// Login route
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  // Query the database for the user
  db.query('SELECT * FROM users WHERE email = ?', [username], (err, results) => {
    if (err) {
      console.error('Error querying MySQL:', err);
      return res.status(500).send('Internal server error');
    }

    if (results.length === 0) {
      return res.status(401).send('Invalid credentials');
    }

    const user = results[0];
    const hashedPassword = crypto.createHash('sha256').update(password).digest('hex');

    if (user.password !== hashedPassword) {
      return res.status(401).send('Invalid credentials');
    }

    const token = jwt.sign({ userId: user.id }, SECRET_KEY, { expiresIn: '1h' });
    res.json({ token });
  });
});

// Middleware to authenticate token
function authenticateToken(req, res, next) {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];

  if (!token) return res.sendStatus(401);

  jwt.verify(token, SECRET_KEY, (err, user) => {
    if (err) return res.sendStatus(403);
    req.user = user;
    next();
  });
}

// Protected route
app.get('/protected', authenticateToken, (req, res) => {
  res.json({ message: 'This is a protected route', user: req.user });
});

// Start server
app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
