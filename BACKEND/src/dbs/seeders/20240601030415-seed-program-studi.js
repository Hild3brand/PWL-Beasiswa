'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert(
      "program_studis",
      [
        {
          kode: "72",
          nama: "Teknik Informatika",
          fakultas_id: "1",
          createdAt: new Date(),
        },
        {
          kode: "73",
          nama: "Sistem Informasi",
          fakultas_id: "1",
          createdAt: new Date(),
        },
      ],
      {}
    );
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('program_studi', null, {});
  }
};
