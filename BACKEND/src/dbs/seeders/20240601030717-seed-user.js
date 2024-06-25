'use strict';

const bcrypt = require('bcrypt');

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert(
      "users",
      [
        {
          nrp: "2272037",
          nama: "Rasyaad Hildebrand Gunawan",
          email: "abc@email.com",
          password: await bcrypt.hash("123", 10),
          status: "Aktif",
          role_id: "1",
          program_studi_id: "1",
          createdAt: new Date(),
        },
        {
          nrp: "2272022",
          nama: "Benedict Wijaya",
          email: "bcd@email.com",
          password: await bcrypt.hash("123", 10),
          status: "Aktif",
          role_id: "2",
          program_studi_id: "1",
          createdAt: new Date(),
        },
        {
          nrp: "2272018",
          nama: "Nathanael Kanaya Chriesman",
          email: "cde@email.com",
          password: await bcrypt.hash("123", 10),
          status: "Aktif",
          role_id: "3",
          program_studi_id: "1",
          createdAt: new Date(),
        },
        {
          nrp: "2372001",
          nama: "Agus",
          email: "123@email.com",
          password: await bcrypt.hash("123", 10),
          status: "Aktif",
          role_id: "4",
          program_studi_id: "1",
          createdAt: new Date(),
        },
      ],
      {}
    );
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('user', null, {});
  }
};
