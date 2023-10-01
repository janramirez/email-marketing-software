# Email Marketing Software
In this project, I try to replicate the email marketing application, ConvertKit. This Laravel project implements a Domain Driven Design structure.

# Features
- manage subscribers
- tags
- email blasts (one-time broadcast emails)
- scheduled email blasts (sequential emails)
- add subscribers to scheduled emails
- subscription forms
- track e-mail opens & link clicks
- generate reports

---
### Subscribers
Subscribers are added to mailing list using:
- subscription forms (implemented via API)
- CSV imports (implemented via Console Commands for Admin)
- manually

Subscribers can also be filtered using tags, how the subscriber was added to the list, etc.

### Emails
After the email content is written and saved, it can either be sent:
- manually using Email blast, or
- by schedule for a later time

The subscribers who will get the email can be defined by using filters such as:
- Tags
- Which form did they come from
(Several methods can be implemented here in the future such as the subscribers' purchases, which type of emails are they subscribed to, etc.)


- **Email blast**  

   - create email blast (including filters, content, etc)
   - send email blast (filters subscribers and queues emails)

   *Metrics* to be tracked from email blasts:
   - How many subscribers got the mail
   - How many subscribers opened the mail (can be expressed as a percentage)
   - How many subscribers clicked on a link inside the content, if there's any link (can be expressed as a percentage)

- **Grouped email schedules**  

   Emails can be grouped together and sent in scheduled sequential manner. For example, an email needs to be sent every week for 4 weeks for new subscribers, instead of manually creating email blasts every week, each email can be sent automatically every week in a proper sequence/order.

   - create mail_group
   - add scheduled emails (includes filters and schedule such as 3 days after last mail)
   - publish mail_group (transition from draft to published)
   - proceed a schedule - This sends the emails. It handles all scheduling logic

### Tracking
Tracking the performance of an email campaign is a must have in an email marketing application. The basic metrics to be implemented are:

- **Total emails sent out**

   Total number sent for each mail

- **Open rate**

    Using an html element to signal when an email was opened

- **Click rate**

   This can be implemented by redirection urls

### Reports
- Progress of scheduled mails
- new subscribers
- daily new subscribers
- metrics for sent mails
- performance for the whole schedule mail sequence

# Data models
The whole database design:

```
subscribers:
   attributes:
      - email
      - first_name
      - last_name
   relationships:
      - form: A subscriber has one form
      - tags: A subscriber has many tags
      - received_mails: A subscriber has many received_mails

tags:
   attributes:
      - title
   relationships:
      - subscribers: A tag has many subscribers

forms:
   attributes:
      - title
      - description
      - content: HTML that can be embedded into websites
   relationships:
      - subscribers: A form has many subscribers

blast:
   attributes:
      - title
      - content: HTML
      - filters: As a JSON Column
      - status
      - sent_at
   relationships:
      - sent_mails: An blast has many sent_mails

mail_group:
   attributes:
      - title
      - status: draft, published
   relationships:
      - scheduled_emails: A mail_group has many scheduled_mails

scheduled_mail:
   attributes:
      - subject
      - status: draft, published
      - content: HTML content
      - filters: JSON field
   relationships:
      - mail_group: A scheduled_mail belongs to one mail_group
      - schedule: A scheduled_mail belongs to one schedule
      - sent_mails: A scheduled_mail has many sent_mails

schedule:
   description:
      - each scheduled_mail has a unique schedule
   attributes:
      - delay
      - unit: hour, day
      - allowed_days: monday, tuesday, etc.

sent_mail:
   description:
      - after sending a blast_mail/scheduled_mail, it is recorded on sent_mail
   attributes:
      - sendable_id: ID of blast_mail/scheduled_mail
      - sendable_type: blast, scheduled
      - subscriber_id
      - sent_at
      - opened_at
      - clicked_at

automations:
   description:
      - container for actual automation steps
   attributes:
      - name
   relationships:
      - steps: An automation has many automation_steps
   
automation_steps:
   description:
      - contains the flow of an event and multiple actions for an automation
   attributes:
      - automation_id
      - type: event, action
      - name
      - value
   relationships:
      - automation: An automation_step belongs to one automation
```

# Domains
Since this project is an implementation of a Domain-Driven Design Architecture, each model lives in a domain that makes sense. Given the following models,  

**Subscriber**  
   The subscriber domain contains classes that are related to subscriber  data  
**Mail**  
   The mail domain contains classes related to email data  
**Automations**  
   The automation domain contains classes used by automation data  
**Shared**  
   The shared domain contains classes that are common to more than one domain  

## Model-Domain Relation

| Model | Domain |
| --- | --- |
| subscriber | Subscriber |
| tag | Subscriber |
| subscriber_tag | Subscriber |
| form | Subscriber |
| blast | Mail |
| schedule | Mail |
| scheduledMail | Mail |
| schedule_scheduledMail | Mail |
| sent_mail | Mail |
| automation | Automation |
| automation_step | Automation |
| *all others* | Shared |