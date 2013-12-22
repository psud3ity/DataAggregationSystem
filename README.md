DataAggregationSystem
=====================

Simple data aggregation and validation system using PHP/MYSQL accepting data from XML documents.

Data in existing excel worksheets is converted to XML via a VBA conversion script embedded in a 
macro enabled excel workbook.

This was a semester long project in Dr. John Hill's IST420 course at Penn State University.

Project Description:

Case Study Background

Access Data Corp., a Broadridge Company, is a leader in enterprise data management, analysis and
reporting for the financial services industry. Today, more than 50 leading asset management firms
utilize their proprietary technology and services to solve a growing problem in the financial 
services industry, the lack of data transparency.

Access Data aggregates and enhances sales and asset data from all record keeping sources,
across all distribution platforms. They then transform the sales data into a valuable business asset
that can be leveraged by the distribution, compliance and finance business areas to improve the
management of critical business processes and drive strategies for growth.

Platform for Enterprise Business Reporting 

Access Data SalesVision® is a web-based, on-demand enterprise shareholder solution that helps financial
services companies:
•	Maximize distribution results 
•	Manage shareholder compliance
•	Track wholesaler and distributor compensations

SalesVision is built on a solid foundation of Data Management services that deliver consistent, reliable
information from one data source. All of their business solutions leverage the same data to provide 
actionable information and market intelligence to managers - across the firm - on products, distribution
channels, sales intermediaries and financial advisers so one can compete more effectively.

Software as a Service Delivery Model 

SalesVision's software solutions are delivered as a service so there is no software or hardware to install 
and enhancements and updates are seamless. Clients can implement proven solutions for complex business problems
quickly and cost-effectively with minimal resources and financial risk. 

Financial Services Expertise 

Access Data’s business, product and technical experts bring hands-on financial services expertise to the table.
We combine best practices – derived from working for leading financial firms – with creative thinking and innovative
technology to deliver solutions that work. 

Mutual Fund Basics

A mutual fund is a portfolio of stocks and/or bonds a managed by an investment company subject to the rules of the
Investment Company Act of 1940. They allow people to invest their money in a diversified manner without having the
large sum of money needed to buy several hundred different stocks and bonds individually. They are marketed to
investment brokers by sales reps called wholesalers. Wholesalers are responsible for a specific territory in the
U.S. and they are paid about 0.01% on every transaction in their territory done in the mutual fund that they 
represent.
Mutual funds are an investment product sold the public by investment brokers. The broker can invest client money 
with the mutual fund in two ways. The first way is to invest the money directly with the mutual fund company. 
By doing the business this way the mutual fund company knows what brokers have sold their product and how much
they have sold. The second way is to have the client’s money in a brokerage account and buy the mutual fund inside
the brokerage account. Doing the business this way the mutual fund company only knows that a particular brokerage
firm has sold their product. All of the transactions done in the mutual fund company’s product are aggregated across
the entire firm. The mutual fund company does not know any of the following information: selling broker, 
selling office, transaction amount, and client name. This aggregation is where the mutual fund company runs into 
problems because it is aggregated nationally, so the mutual fund company is unaware of what wholesaler’s territory
should be credited with the business, making it difficult to pay their wholesalers properly.

The Problem

This problem for mutual fund companies is where Access Data Corporation has built a niche business by collecting 
transaction data from all over the country they are able to disaggregate and process the information to tell the
mutual fund companies who sold their product as well as where and how much. In order for the mutual fund company
to access this information, they purchase software as a service from Access Data Corporation, which runs as a
secure web portal through a standard web browser. Typically, this has to be set up and customized for each mutual
fund company. The standard contract with the mutual fund companies allows for 40 hours of time for customization,
over that the mutual fund company is billed an hourly rate. 

A concern of Access Data Corporation is keeping track of the amount of time they spend customizing for each mutual
fund company.  They are concerned that they may be losing revenue by not billing accurately for their time in excess
of the contracted 40 hours. Moreover, Access Data Corporation would like to allocate resources more efficiently by
identifying the top 20% of their clients that typically generate 80% of their revenue. They may be missing a 
Good-will opportunity with these clients because they cannot pinpoint the total amount of time, over the contracted
40 hours, for customization. They would also like to identify the bottom 20% that generate little revenue or cost 
them revenue so those clients can be better developed to generate more revenue. They have three departments that work
with the client: sales & contracting, client service management, and project & data management. Each group uses 
different computer systems, tracks time differently, and has different data reporting priorities. They need a way
to integrate and consolidate how these departments keep track of the time they spend on each client and have that
time totaled and tracked for billing.

Helpful Notes
These notes are relevant to many phases of the case:
•	Clients have projects.
•	Clients may have multiple projects.
•	Projects 'belong' to one, and only one, client.
•	Clients have contact information (address, fax number, etc.).
•	Each project has one, and only one, primary contact person.
•	Contact persons have contact information, and a preferred means of contact.
