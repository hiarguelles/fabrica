USE [master]
GO
/****** Object:  Database [brad_fabrica]    Script Date: 6/21/2022 7:26:10 PM ******/
CREATE DATABASE [brad_fabrica]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'brad_fabrica', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.SQLEXPRESS\MSSQL\DATA\brad_fabrica.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'brad_fabrica_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.SQLEXPRESS\MSSQL\DATA\brad_fabrica_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [brad_fabrica] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [brad_fabrica].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [brad_fabrica] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [brad_fabrica] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [brad_fabrica] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [brad_fabrica] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [brad_fabrica] SET ARITHABORT OFF 
GO
ALTER DATABASE [brad_fabrica] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [brad_fabrica] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [brad_fabrica] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [brad_fabrica] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [brad_fabrica] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [brad_fabrica] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [brad_fabrica] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [brad_fabrica] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [brad_fabrica] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [brad_fabrica] SET  DISABLE_BROKER 
GO
ALTER DATABASE [brad_fabrica] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [brad_fabrica] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [brad_fabrica] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [brad_fabrica] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [brad_fabrica] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [brad_fabrica] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [brad_fabrica] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [brad_fabrica] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [brad_fabrica] SET  MULTI_USER 
GO
ALTER DATABASE [brad_fabrica] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [brad_fabrica] SET DB_CHAINING OFF 
GO
ALTER DATABASE [brad_fabrica] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [brad_fabrica] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [brad_fabrica] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [brad_fabrica] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
ALTER DATABASE [brad_fabrica] SET QUERY_STORE = OFF
GO
USE [brad_fabrica]
GO
/****** Object:  User [webser]    Script Date: 6/21/2022 7:26:11 PM ******/
CREATE USER [webser] FOR LOGIN [webser] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  Table [dbo].[BaseOrigen]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[BaseOrigen](
	[id_base] [int] NOT NULL,
	[fecha] [date] NOT NULL,
	[socio] [nvarchar](50) NOT NULL,
	[caso] [bigint] NOT NULL,
	[solicitud] [nvarchar](25) NOT NULL,
	[status] [nvarchar](25) NOT NULL,
	[hit] [int] NOT NULL,
	[perfil] [nvarchar](50) NOT NULL,
	[motivo] [nvarchar](500) NOT NULL,
	[rec1] [nvarchar](500) NULL,
	[mensaje_tienda] [nvarchar](500) NULL,
	[rec2] [nvarchar](500) NULL,
	[identificacion] [nvarchar](2) NOT NULL,
	[talon] [nvarchar](2) NOT NULL,
	[foto_th_id] [nvarchar](2) NOT NULL,
	[contrato] [nvarchar](2) NOT NULL,
	[aviso_privacidad] [nvarchar](2) NOT NULL,
	[firmas] [nvarchar](2) NOT NULL,
	[observaciones] [nvarchar](1000) NOT NULL,
	[nombre] [nvarchar](100) NULL,
 CONSTRAINT [PK_BaseOrigen_caso] PRIMARY KEY CLUSTERED 
(
	[caso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[BaseOrigen_copy2]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[BaseOrigen_copy2](
	[id_base] [int] NOT NULL,
	[fecha] [date] NULL,
	[socio] [nvarchar](50) NOT NULL,
	[caso] [bigint] NOT NULL,
	[solicitud] [nvarchar](25) NOT NULL,
	[status] [nvarchar](25) NOT NULL,
	[hit] [int] NOT NULL,
	[perfil] [nvarchar](50) NOT NULL,
	[motivo] [nvarchar](500) NOT NULL,
	[rec1] [nvarchar](500) NULL,
	[mensaje_tienda] [nvarchar](500) NULL,
	[rec2] [nvarchar](500) NULL,
	[identificacion] [nvarchar](2) NOT NULL,
	[talon] [nvarchar](2) NOT NULL,
	[foto_th_id] [nvarchar](2) NOT NULL,
	[contrato] [nvarchar](2) NOT NULL,
	[aviso_privacidad] [nvarchar](2) NOT NULL,
	[firmas] [nvarchar](2) NOT NULL,
	[observaciones] [nvarchar](1000) NOT NULL,
 CONSTRAINT [PK_BaseOrigen_copy2] PRIMARY KEY CLUSTERED 
(
	[socio] ASC,
	[caso] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Cat_CalificacionesOUT]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Cat_CalificacionesOUT](
	[ID_Calificacion] [int] IDENTITY(1,1) NOT NULL,
	[Descripcion] [nvarchar](100) NULL,
	[Referencia] [int] NULL,
	[TipoContacto] [nvarchar](30) NULL,
	[Calificacion] [nvarchar](30) NULL,
	[Subcalificacion] [nvarchar](30) NULL,
	[Estatus] [int] NULL,
	[activo] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Calificacion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[evaluacion]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[evaluacion](
	[id_evaluacion] [bigint] IDENTITY(1,1) NOT NULL,
	[caso] [bigint] NOT NULL,
	[id_usuario] [int] NOT NULL,
	[fecha] [datetime] NOT NULL,
	[identificacion] [int] NOT NULL,
	[talon] [int] NOT NULL,
	[foto] [int] NOT NULL,
	[contrato] [int] NOT NULL,
	[firma] [int] NOT NULL,
	[privacidad] [int] NOT NULL,
	[comentarios] [nvarchar](max) NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Gestion]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Gestion](
	[ID_Gestion] [bigint] IDENTITY(1,1) NOT NULL,
	[TipoContacto] [int] NULL,
	[Calificacion] [int] NULL,
	[SubCalificacion] [int] NULL,
	[TipoContactoIN] [int] NULL,
	[CalificacionIN] [int] NULL,
	[SubCalificacionIN] [int] NULL,
	[Comentarios] [nvarchar](300) NULL,
	[TelNuevo] [nvarchar](10) NULL,
	[MailNuevo] [nvarchar](60) NULL,
	[Correo] [nvarchar](60) NULL,
	[FechaGestion] [datetime] NULL,
	[Calificado] [nvarchar](10) NULL,
	[Flag] [int] NULL,
	[ID_BaseOrigen] [bigint] NULL,
	[FolioVenta] [nvarchar](12) NULL,
	[CodSMS] [nvarchar](10) NULL,
	[Agente] [nvarchar](15) NULL,
	[IDLamada] [nvarchar](80) NULL,
	[Activa] [int] NULL,
	[PrecioInput] [nvarchar](30) NULL,
	[PagosInput] [nvarchar](50) NULL,
	[cuentaInput] [nchar](20) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Gestion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Interacciones]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Interacciones](
	[ID_Interacciones] [bigint] IDENTITY(1,1) NOT NULL,
	[TELEFONO] [nvarchar](12) NOT NULL,
	[AGENTE] [nvarchar](50) NULL,
	[ID_DATOS] [nvarchar](50) NOT NULL,
	[IDLLAMADA] [nvarchar](50) NULL,
	[INTERACTIONID] [nvarchar](50) NULL,
	[LOTE] [nvarchar](50) NULL,
	[CAMPANA] [nvarchar](50) NULL,
	[FECHAINSERCION] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID_Interacciones] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tabla_bloqueo]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tabla_bloqueo](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[caso] [int] NOT NULL,
	[id_usuario] [int] NOT NULL,
	[fec_lock] [datetime] NOT NULL,
	[status_lock] [nvarchar](1) NOT NULL,
	[actusuario] [nvarchar](75) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Usuarios]    Script Date: 6/21/2022 7:26:11 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Usuarios](
	[Id_Usuario] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [nvarchar](50) NOT NULL,
	[Pass] [nvarchar](200) NOT NULL,
	[Puesto] [nvarchar](50) NOT NULL,
	[Actfecha] [datetime] NOT NULL,
	[Menu] [nvarchar](20) NULL,
	[Nombre] [nvarchar](100) NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([Calificacion])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([Calificacion])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([SubCalificacion])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([SubCalificacion])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([TipoContacto])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
ALTER TABLE [dbo].[Gestion]  WITH CHECK ADD FOREIGN KEY([TipoContacto])
REFERENCES [dbo].[Cat_CalificacionesOUT] ([ID_Calificacion])
GO
USE [master]
GO
ALTER DATABASE [brad_fabrica] SET  READ_WRITE 
GO
