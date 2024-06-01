'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert(
      'role',
      [
        {
          nama_role: 'Admin',
          created_at: new Date(),
          updated_at: new Date(),
        },
        {
          nama_role: 'Fakultas',
          created_at: new Date(),
          updated_at: new Date(),
        },
        {
          nama_role: 'Program Studi',
          created_at: new Date(),
          updated_at: new Date(),
        },
        {
          nama_role: 'Mahasiswa',
          created_at: new Date(),
          updated_at: new Date(),
        },
      ],
      {}
    );
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('role', null, {});
  }
};
