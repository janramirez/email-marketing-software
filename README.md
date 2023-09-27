# Email Marketing Software
In this project, I try to replicate the email marketing application, ConvertKit. This Laravel project implements a Domain Driven Design structure.

## Features
- manage subscribers
- tags
- email blasts (one-time broadcast emails)
- scheduled email blasts (sequential emails)
- add subscribers to scheduled emails
- subscription forms
- track e-mail opens & link clicks
- generate reports

##
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

Metrics to be tracked from email blasts:
- How many subscribers got the mail
- How many subscribers opened the mail (can be expressed as a percentage)
- How many subscribers clicked on a link inside the content, if there's any link (can be expressed as a percentage)

#### Email blast

- create email blast (including filters, content, etc)
- send email blast (filters subscribers and queues emails)

#### Scheduled email sequence
Scheduled emails can be grouped together and sent in scheduled sequential manner. For example, an email needs to be sent every week for 4 weeks for new subscribers, instead of manually creating email blasts every week, each email can be sent automatically every week in a proper sequence/order.

- create schedules
- add scheduled emails (includes filters and schedule such as 3 days after last mail)
- publish schedule (transition from draft to published)
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

## Data models

**subscribers:**

Attributes:
- email
- first_name
- last_name

Relationships:
- form: A **subscriber** has one **form**
- tags: A **subscriber** has many **tags**
- received_mails: A **subscriber** has mane **received_mails**

**tags**

Attributes:
- title

Relationships:
- subscribers: A **tag** has many **subscribers**

**forms**

Attributes:
- title
- content: HTML that can be embedded into websites

Relationships:
- subscribers: A **form** has many **subscribers**

**email_blast**

Attributes:
- title
- content: HTML
- filters: As a JSON Column such as below 👇 instead of creating extra database tables 

   ```
   {
    "form_ids": [1, 2, 3]
    "tag_ids": [2, 4]
   }
   ```
- status
- sent_at

Relationships:
- sent_mails: An **email_blast** has many **sent_mails**. One for each subscriber


### Scheduled Emails
- A sequence contains multiple scheduled emails
- Each email has a schedule

It will handle scheduling conditions such as
- 4 days after last email has been sent, but only on Fridays
- 5 hours after the last email on any day

<br>

**schedules**

Attributes:
- title
- status: draft or published

Relationships:
- scheduled_mails: A **schedule** has many **scheduledMails**


**scheduledMails**

Attributes:
- subject
- status: draft or published
- content: HTML content
- filters: JSON field

Relationships:
- schedule: A **scheduledMail** belongs to one **schedule**
- sent_mails: A **scheduledMail** has many **sent_mails**

> *Note*: A scheduled mail is similar to an email blast mail; it also has:
> - a subject line
> - HTML content
> - JSON Filters

**schedule_scheduledMails**  
Description: each scheduledMail has a unique schedule such as 5 days after the last email, and only on Fridays.

Attributes:
- delay
- unit
- allowed_days

**sent_mails**  
Description: after sending an email blast or a scheduled mail, it becomes a sent_mail record.
Attributes:
- sendable_id: ID of email_blast or scheduledMail
- sendable_type: email_blast, scheduledMail
- sent_at
- opened_at
- clicked_at

**automations**  
Description: container for the actual steps 

Attributes:
- name

Relationships:
- steps: An **automation** has many **steps**

**automation_steps**  
Description: contains the flow of an event and multiple actions for automation

Attributes:
- automation_id
- type: event, action
- name
-value: JSON Column (for unstructured data. *Example below* 👇)

>| id  | automation_id | type  | name  | value |
>| :---: | :---: | --- | --- | --- |
>| 1 | 1 | event |subscribeToForm | {"form_id":1} |
>| 2 | 1 | action |addToSchedule | {"schedule_id":3} |

Relationships:
- automation: An **automation_step** belongs to one **automation**

## Domains
Since this project is an implementation of a Domain-Driven Design Architecture, each model lives in a domain that makes sense. Given the following models,
- subscribers
- tags
- subscriber_tag
- forms
- email_blasts
- schedules
- schedule_scheduledMails
- scheduledMails
- sent_mail
- automations
- automation_steps

| Model | Domain |
| --- | --- |
| subscribers | Subscriber |
| tags | Subscriber |
| subscriber_tag | Subscriber |
| forms | Subscriber |
| email_blasts | Mail |
| schedules | Mail |
| scheduledMails | Mail |
| schedule_scheduledMails | Mail |
| sent_mail | Mail |
| automations | Automation |
| automation_steps | Automation |
| *all others* | Shared |

