using System;
using Microsoft.EntityFrameworkCore.Metadata;
using Microsoft.EntityFrameworkCore.Migrations;

namespace SacramentPlanner.Migrations
{
    public partial class Theme : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "Sunday",
                columns: table => new
                {
                    Id = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    Date = table.Column<DateTime>(nullable: false),
                    Conductor = table.Column<string>(nullable: false),
                    OpeningHymn = table.Column<int>(nullable: false),
                    ClosingHymn = table.Column<int>(nullable: false),
                    SacramentHymn = table.Column<int>(nullable: false),
                    IntermediateSong = table.Column<string>(nullable: true),
                    OpeningPrayer = table.Column<string>(nullable: false),
                    ClosingPrayer = table.Column<string>(nullable: false),
                    Theme = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Sunday", x => x.Id);
                });

            migrationBuilder.CreateTable(
                name: "Speaker",
                columns: table => new
                {
                    SpeakerID = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    SundayID = table.Column<int>(nullable: false),
                    Name = table.Column<string>(nullable: false),
                    Subject = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Speaker", x => x.SpeakerID);
                    table.ForeignKey(
                        name: "FK_Speaker_Sunday_SundayID",
                        column: x => x.SundayID,
                        principalTable: "Sunday",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateIndex(
                name: "IX_Speaker_SundayID",
                table: "Speaker",
                column: "SundayID");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "Speaker");

            migrationBuilder.DropTable(
                name: "Sunday");
        }
    }
}
