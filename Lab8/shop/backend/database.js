const { Pool } = require('pg');
const pgp = require('pg-promise')();

const dbConfig = {
    user: 'postgres',
    host: 'localhost',
    database: 'postgres',
    password: '12345',
    port: 5432
};

const db = pgp(dbConfig);

const getData = async (name) => {
    try {
        const data = await db.any(`SELECT * FROM products WHERE name ILIKE '%${name}%'`);
        return data;
    } catch (error) {
        throw error;
    }
};

module.exports = { getData };
